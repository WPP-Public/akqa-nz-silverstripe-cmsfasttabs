#Heyday CMS Fast tabs

This module is designed to reduce the load time of CMS SiteTree pages. It achieves this by allowing a developer to create tabs which only load content when the tab is clicked (as opposed to whenever the SiteTree page loads).

##Installation

###Regular install
To install just drop the silverstripe-cmsfasttabs directory into your SilverStripe root and run a ?flush=1

###Composer
Installing from composer is easy,

Create or edit a `composer.json` file in the root of your SilverStripe project, and make sure the following is present.

```json
{
    "require": {
        "heyday/silverstripe-cmsfasttabs": "*"
    }
}
```
After completing this step, navigate in Terminal or similar to the SilverStripe root directory and run composer install or composer update depending on whether or not you have composer already in use.

##How to use

A fast tab is implemented in two steps. 

###Step 1

Add your FastTab to a TabSet in your getCMSFields. The constructor requires 4 arguments.

1. Tab Name
2. Object that contains the method which returns the slow loading Tab
3. And the name of the method to be called. This argument is automatically prefixed with "tab".

####Code

	$contentTabSet = $fields->fieldByName('Root.Content');
	$contentTabSet->push(new FastTab('BigTab', $this, 'Big'));
	
###Step 2

Create the method that returns the slow loading Tab. This example corresponds with Step 1.

####Code

	public function tabBig()
	{

		return new Tab(
			'BigTab',
			new FileDataObjectManager($this, 'Resources', 'Resource', 'File', array('Name' => 'Name')),
			new DataObjectManager($this, 'Things', 'Thing', array('Name' => 'Name'))
		);

	}
	

##Examples

###Standard getCMSFields setup

	public function getCMSFields()
	{

		$fields = parent::getCMSFields();

		$contentTabSet = $fields->fieldByName('Root.Content');
		$contentTabSet->push(new FastTab('BigTab', $this, 'Big'));
		return $fields;

	}

	public function tabBig()
	{

		return new Tab(
			'BigTab',
			new FileDataObjectManager($this, 'Resources', 'Resource', 'File', array('Name' => 'Name')),
			new DataObjectManager($this, 'Things', 'Thing', array('Name' => 'Name'))
		);

	}

###DataObjectDecorator setup

	public function updateCMSFields(FieldSet &$fields)
	{

		$contentTabSet = $fields->fieldByName('Root.Content');
		$contentTabSet->push(new FastTab('ExtensionTest', $this->owner, 'ExtensionTest'));

	}

	public function tabExtensionTest()
	{

		return new Tab(
			'ExtensionTest',
			new ImageField('ExtraImage', 'ExtraImage'),
			new HtmlEditorField('ExtraContent', 'ExtraImage')
		);

	}


#Progress Notes

Just discovered that ModelAdmin doesn't implement the updateEditForm hook

Need to name tabs containing DOMs with the same name as the relation e.g. 'Things'
