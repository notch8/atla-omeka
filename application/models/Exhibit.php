<?php
require_once 'Section.php';
require_once 'Tag.php';
require_once 'Taggings.php';
require_once 'Taggable.php';
require_once 'ExhibitTable.php';
require_once 'ExhibitTaggings.php';
/**
 * Exhibit
 * @package: Omeka
 */
class Exhibit extends Kea_Record
{
	protected $error_messages = array(	
		'slug' => array('notblank' => 'Exhibit must be given a valid slug.', 
						'unique' => 'Your URL slug is already in use by another exhibit.  Please choose another.'),
		'title' => array('notblank' => 'Exhibit must be given a title.')		
				);
	
	protected $_taggable;
	
    public function setTableDefinition()
    {
		$this->option('type', 'MYISAM');
		$this->setTableName('exhibits');
		$this->hasColumn("title", "string", 255, "notblank");
		$this->hasColumn("description", "string");
		$this->hasColumn("credits", "string");
		$this->hasColumn("featured", "boolean");
		$this->hasColumn('public', 'boolean');
		
		//Display info (not archival)
		$this->hasColumn("theme","string",30);
		$this->hasColumn("slug", "string", 30,"unique|notblank");
    }

    public function setUp()
    {
		$this->ownsMany('Section as Sections', 'Section.exhibit_id');
		$this->ownsMany("ExhibitTaggings", "ExhibitTaggings.relation_id");
    }
	
	public function get($name)
	{
		switch ($name) {
			//I had to do this same damn thing in the Item model.  This is pissing me off.
			case 'Tags':
				return $this->getTags();
				break;

			default:
				return parent::get($name);
				break;
		}
	}
	
	public function construct()
	{
		$this->_strategies[] = new Taggable($this);
	}
	
	public function generateSlug($title)
	{
		//Convert the title of the exhibit to a usable slug
		$slug = $title;
		
		//Replace prohibited characters in the title with - 's
		$prohibited = array(':', '/', ' ', '.');
		$replace = array_fill(0, count($prohibited), '-');
		$slug = str_replace($prohibited, $replace, strtolower($slug) );
		return $slug;
	}
	
	protected function preCommitForm(&$post, $options)
	{					
		//Whether or not the exhibit is featured
		$this->featured = (bool) $post['featured'];
		unset($post['featured']);
		
		if(!empty($post['Sections'])) {
			//Change the order of the sections
			foreach ($post['Sections'] as $key => $section) {
				$this->Sections[$key]->order = $section['order'];
			}
			$this->Sections->save();
		}		
		
		//Make an exhibit slug if the posted slug is empty
		//This is duplicated exactly in the Section class
		$slugFodder = !empty($post['slug']) ? $post['slug'] : $post['title'];
		$post['slug'] = $this->generateSlug($slugFodder);
	}
	
	protected function postCommitForm($post, $options)
	{
		//Add the tags after the form has been saved
		$current_user = Kea::loggedIn();		
		$this->applyTagString($post['tags'], $current_user->Entity, true);
		
		//reload the sections b/c Doctrine is too dumb to do it
		$this->loadSections();
	}
	
	public function reorderSections()
	{
		$this->loadSections();
		$i = 1;
		foreach ($this->Sections as $key => $section) {
			$section->order = $i;
			$section->save();
			$i++;
		}
		
		return $this;
	}

	public function loadSections()
	{
		$dql = "SELECT s.* FROM Section s WHERE s.exhibit_id = {$this->id} ORDER BY s.section_order ASC";
		$q = new Doctrine_Query;
		$sections = $q->parseQuery($dql)->execute();
		$this->Sections = $sections;
	}
	
	public function getSection($slug)
	{
		$dql = "SELECT s.* FROM Section s LEFT JOIN s.Pages p WHERE s.slug = ? AND s.exhibit_id = ? LIMIT 1";
        return $this->executeDql($dql, array( strtolower($slug), $this->id), true);	
	}
	
	/**
	 * The number of sections in the exhibit
	 *
	 * @return int
	 **/
	public function getSectionCount()
	{
		$sql = "SELECT COUNT(*) FROM sections WHERE exhibit_id = ?";
		return $this->execute($sql, array($this->id), true);
	}
}

?>