<?php
/**
 * FastTabsCMSMainExtension adds fields from FastTabs to the EditForm fieldset when they need to be present during a request
 */
class FastTabsCMSMainExtension extends Extension
{

    public static $allowed_actions = array(
        'FastTab'
    );

    public function handleForm(Form $form, $request)
    {

            $fields = $form->Fields();

            $FastTab = $fields->findFastTab($request->postVar('TabName'));

            if ($FastTab instanceof FastTab) {

                $tab = $FastTab->build($form);

                $form->setFields(new FieldSet($tab));

                $form->loadDataFrom($form->getRecord());

                return $tab->renderWith('FastTab');

            } else {
                return false;

            }

    }

    public function FastTab()
    {

        //http://silverstripe/admin/EditForm/field/Things/item/2118/DetailForm/field/AwesomeImage/iframe

        $request = $this->owner->getRequest();

        if ($this->owner instanceof ModelAdmin_RecordController) {

            $form = $this->owner->EditForm();

        } else {

            $form = $this->owner->getEditForm($this->owner->currentPageID());

        }

        if ($result = $this->handleForm($form, $request)) {
            return $result;

        } elseif ($request->shift() == 'field') {

            $field = $form->dataFieldByName($request->shift());

            if ($request->shift() == 'item') {

                $itemRequest = new DataObjectManager_ItemRequest($field, $request->shift());

                $form = $itemRequest->DetailForm();

                if ($result = $this->handleForm($form, $request)) {
                    return $result;

                }

            }

        }

        return user_error('No FastTab found');

    }

}
