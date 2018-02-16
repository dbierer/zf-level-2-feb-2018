# ZEND FRAMEWORK FUNDAMENTALS II -- Course Notes
Updated note: 

https://github.com/dbierer/zf-level-2-feb-2018



Left off with: http://localhost:8888/#/3/9

## Homework
* Homework for Wed 7 Feb 2018
  * Lab: Abstract Factories
  * Lab: Delegators

## Service Container
### Abstract Factory
* Example: see in guestbook: AuthOauth\Factory\AdapterAbstractFactory
### Reflect Abstract Factory
* Example: see in guestbook: module.config.php
```
    TableModule\Model\EventTable::class        => ReflectionBasedAbstractFactory::class,
    TableModule\Model\AttendeeTable::class     => ReflectionBasedAbstractFactory::class,
    TableModule\Model\RegistrationTable::class => ReflectionBasedAbstractFactory::class,
```
### Config Abstract Factory
* Example: see guestbook: `/module/Events/config/module.config.php` lines 189 and 202 - 213
### Delegators
* Example: see guestbook: `/module/Events/config/module.config.php` lines 189 and 202 - 213
* Also in guestbook: `\Doctrine\Factory\SignupDelegatorFactory`

## VM UPDATES
* Look at the ACL for Guestbook: logged in admin but can't see Admin Area under Events
* *IMPORTANT* please replace `onlinemarket.work/module/Market/view/partials/item.phtml` with this:
```
<?php
    $locale = \Locale::getDefault();
    switch ($locale) {
        case 'en' :
            $code = 'USD';
            break;
        case 'es' :
        case 'de' :
        case 'fr' :
            $code = 'EUR';
            break;
        default :
            $code = 'GBP';
    }
?>
<div class="span7">
    <style>
    th {
        text-align: right;
    }
    .listingImage {
        float: left;
        width: 40%;
        height: 800px;
    }
    .listingNotes {
        float: left;
        width: 60%;
    }
    .tableSpace {
        width: 100px;
    }
    </style>
    <p>
        <?php if ($this->item) : ?>
        <h3><i><?php echo $this->escapeHtml($this->item->title); ?></i></h3>
        <table width="60%" cellspacing="5px" cellpadding="5px">
            <tr>
                <!-- //*** I18N FORMATTING LAB: display using I18N currency view helper -->
                <td><h4><?php echo number_format($this->item->price, 2); ?></h4></td>
                <td><h4><?php echo $this->escapeHtml($this->item->city); ?></h4></td>
                <td><h4><?php echo $this->escapeHtml($this->item->country); ?></h4></td>
            </tr>
        </table>
        <hr />
        <div class="listingImage">
            <?php $photoFilename = $this->escapeHtml($this->item->photo_filename); ?>
            <?php if (stripos($photoFilename, 'http:') === FALSE) $photoFilename = $this->basePath() . $photoFilename; ?>
            <img src="<?php echo  $photoFilename; ?>" width="200px"/>
            </div>
            <div class="listingNotes">
            <table cellspacing="10px" cellpadding="10px" class="tableClass">
                <!-- //*** TRANSLATION LAB: display using translate view helper -->
                <tr><th>Category</th><td class="tableSpace">&nbsp;</td><td><?php echo $this->escapeHtml($this->item->category); ?></td></tr>
                <tr><th>Posted</th><td class="tableSpace">&nbsp;</td><td><?php echo $this->escapeHtml($this->item->date_created); ?></td></tr>
                <tr><th>Expires</th><td class="tableSpace">&nbsp;</td><td><?php echo $this->escapeHtml($this->item->date_expires); ?></td></tr>
                <tr><th>Name</th><td class="tableSpace">&nbsp;</td><td><?php echo $this->escapeHtml($this->item->contact_name); ?></td></tr>
                <tr><th>Phone</th><td class="tableSpace">&nbsp;</td><td><?php echo $this->escapeHtml($this->item->contact_phone); ?></td></tr>
                <tr><th>Email</th><td class="tableSpace">&nbsp;</td><td><?php echo $this->escapeHtml($this->item->contact_email); ?></td></tr>
            </table>
        </div>
        <hr>
        <p><?php echo $this->escapeHtml($this->item->description); ?></p>
        <hr />
        <?php else : ?>
            Unable to find listing!
        <?php endif; ?>
    </p>
</div>
```

## LAB NOTES
### SERVICE CONTAINER LABS
* Abstract Factory Lab:
  * Error message when you go to this URL: `http://onlinemarket.work/events/signup/` 
```
Fatal error: Interface 'Events\Controller\ServiceLocatorAwareInterface' not found in /home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.work/module/Events/src/Controller/SignupController.php on line 10
```
  * Solution: remove `implements ServiceLocatorAwareInterface` 

### TRANSLATION LAB:
* Need to replace the contents of the files shown here:
  * `onlinemarket.work/module/Translation/language/de.php`
```
// not ready yet!
```
  * `onlinemarket.work/module/Translation/language/es.php`
```
// not ready yet!
```

### AccessControl Redirect Issue
#### Notes
* Not a fatal problem
* Messes up screen redrawing
* Affects:
  * guestbook
  * onlinemarket.work
  * onlinemarket.complete
#### Solution
* In these 3 files:
  * `guestbook/module/AccessControl/src/Listener/AclListenerAggregate.php`:
  * `onlinemarket.work/module/AccessControl/src/Listener/AclListenerAggregate.php`:
  * `onlinemarket.completemodule/AccessControl/src/Listener/AclListenerAggregate.php`:
* Change this:
```
$match->setParam('controller', self::DEFAULT_CONTROLLER);
return $response;
```

