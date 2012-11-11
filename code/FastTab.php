<?php
/**
 * FastTab is an extension of Tab that can be used when you want a tabs content loaded only when the tab is clicked on.
 * This is useful in situations where a particular tab has a lot of database calls or takes a lot of processing time to render.
 */
class FastTab extends Tab
{

    protected $object = false;
    protected $method = false;
    protected $buildOn = array();

    public function __construct($name, $obj, $buildOn = false, $method = false)
    {

        SSViewer::set_theme('cmsfasttabs');

        parent::__construct($name);

        $this->setObject($obj);

        $this->setMethod($method ? $method : $name);

        $this->setBuildOn($buildOn && is_array($buildOn) ? $buildOn : array(
            'TriggerBuild_' . $name,
            $name
        ));

        $this->addRequirements();

    }

    public function setForm($form)
    {

        $request = Controller::curr()->getRequest();

        if ($this->allowBuild($request)) {

            $tab = $this->build($form);

            $tabFields = array();

            $tab->collateDataFields($tabFields);

            foreach ($tabFields as $field) {

                $this->push($field);

            }

        }

        $this->form = $form;

    }

    /**
     * This method builds a regular Tab based on the configuration of FastTab
     */
    public function build($form)
    {

        $method = 'tab' . $this->method;

        if ($this->object instanceof DataObject && $this->object->hasMethod($method)) {

            $tab = $this->object->$method();

            if ($tab instanceof Tab) {

                $tab->push(new HiddenField('TriggerBuild_' . $this->Name()));
                $tab->setForm($form);

                return $tab;

            } else {

                user_error('FastTab: The called method doesn\'t return a Tab', E_USER_ERROR);

            }

        } else {

            user_error('FastTab is not properly configured, either object doesn\'t extends DataObject or method doesn\'t exist', E_USER_ERROR);

        }

    }
    public function setBuildOn($buildOn)
    {

        $this->buildOn = $buildOn;

    }
    /**
     * Setter method. Sets the object that contains the method that returns the real tab.
     */
    public function setObject($obj)
    {

        $this->object = $obj;

    }
    /**
     * Setter method. Sets the method to be called on the object FastTab is configured with
     */
    public function setMethod($method)
    {

        $this->method = $method;

    }
    public function allowBuild(SS_HTTPRequest $request)
    {
        //http://silverstripe/admin/EditForm/field/Things/item/13/edit?

        $postVars = $request->postVars();
        $postVars[$request->param('OtherID')] = true;

        foreach ($this->buildOn as $check) {

            if (array_key_exists($check, $postVars)) {
                return true;

            }

        }

        return false;

    }
    /**
     * Returns the Url that needs to be called to get the tabs content
     */
    public function FastTabName()
    {
        return $this->name;

    }
    /**
     * Add the requirements to the page so the tabs load the resource when clicked.
     */
    public function addRequirements()
    {

        Requirements::javascript(THIRDPARTY_DIR.'/jquery/jquery.js');
        Requirements::javascript(THIRDPARTY_DIR.'/jquery-livequery/jquery.livequery.js');
        Requirements::javascript('silverstripe-cmsfasttabs/javascript/cmsfasttabs.js');

    }

}
