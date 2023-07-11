<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2012
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package ExhibitBuilder
 */

/**
 * Mixin for "sluggable" records.
 *
 * The only requirement for a record to use this mixin is that it needs a
 * field named 'slug'.
 *
 * @package ExhibitBuilder
 */
class Mixin_Slug extends Omeka_Record_Mixin_AbstractMixin
{
    protected $parentFields = array();
    protected $options;

    function __construct($record, $options = array())
    {
        parent::__construct($record);

        $defaultOptions = array(
            'parentFields' => array(),
            'slugMaxLength' => 30,
            'slugSeedFieldName' => 'title'
        );

        $errorMsgs = array(
            'slugEmptyErrorMessage' => 'Slug must be provided.',
            'slugLengthErrorMessage' => 'Slug must not be more than ' . $defaultOptions['slugMaxLength'] . ' characters.',
            'slugUniqueErrorMessage' => 'Slug must be unique.'
        );

        $this->options = array_merge($defaultOptions, $errorMsgs, $options);

        $this->parentFields = $this->options['parentFields'];

        $this->_record = $record;
    }

    private function filterByParents($select)
    {
        if ($this->parentFields) {
            foreach ($this->parentFields as $field) {
                $parentId = $this->_record->{$field};
                if ($parentId) {
                    $select->where($field . ' = ?', $parentId);
                } else {
                    $select->where($field . ' IS NULL');
                }
            }
        }
    }

    public function validateSlug()
    {
        $seedValue = '';

        // Create a slug if one was not specified.
        if (trim($this->_record->slug) == '') {
            $seedValue = $this->_record->{$this->options['slugSeedFieldName']};
        } else {
            $seedValue = $this->_record->slug;
        }
        $this->_record->slug = self::generateSlug($seedValue);

        if (trim($this->_record->slug) == '') {
            $this->_record->addError('slug', $this->options['slugEmptyErrorMessage']);
        }

        if (!$this->slugIsUnique($this->_record->slug)) {
            $this->_record->addError('slug', $this->options['slugUniqueErrorMessage']);
        }

        if (strlen($this->_record->slug) > $this->options['slugMaxLength']) {
            $this->_record->addError('slug', $this->options['slugLengthErrorMessage']);
        }
    }

    public function beforeSave($args)
    {
        $this->validateSlug();
    }

    public function slugIsUnique($slug)
    {
        // ...
    }

    public static function generateSlug($text)
    {
        // ...
    }
}
