<?php
/**
 * Provides various helper methods for dealing with FastTabs in field sets
 */
class FastTabsFieldSetExtension extends Extension
{

    protected $tabs = array();

    public function findFastTabs($force = false)
    {

        if (count($this->tabs) == 0) {

            $this->collect($this->owner);

        }

        return $this->tabs;

    }

    public function findFastTab($name)
    {
        return $this->findByName($this->owner, $name);

    }

    public function addTabRequirements()
    {

        foreach ($this->findFastTabs() as $tab) {

            $tab->addRequirements();

        }

        unset($tab);

    }

    public function findByName($group, $name)
    {

        $found = false;

        foreach ($group as $child) {

            if ($child instanceof FastTab && $child->Name() == $name) {

                $found = $child;

                break;

            }

            if ($child->isComposite()) {

                $found = $this->findByName($child->FieldSet(), $name);

                if ($found) {

                    break;

                }

            }

        }

        unset($child);

        return $found;

    }

    public function collect($group)
    {

        foreach ($group as $child) {

            if ($child->isComposite()) {

                $this->collect($child->FieldSet());

            }

            if ($child instanceof FastTab) {

                $this->tabs[$child->Name()] = $child;

            }

        }

        unset($child);

    }

}
