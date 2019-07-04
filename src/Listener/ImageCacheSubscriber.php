<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use App\Entity\Pokemon;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ImageCacheSubscriber implements EventSubscriber {

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $helper) {
        $this->cacheManager = $cacheManager;
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(){
        // implement
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if(!$entity instanceof Pokemon) {
            return;
        }
        $this->cacheManager->remove($this->helper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args){

        $entity = $args->getEntity();

        if(!$entity instanceof Pokemon){
            return;
        }

        if($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->helper->asset($entity, 'imageFile'));
        }
    }

    public function getCacheManager(): CacheManager
    {
        return $this->cacheManager;
    }

    public function setCacheManager($cacheManager): self
    {
        $this->cacheManager = $cacheManager;
    }

    public function getHelper(): UploaderHelper
    {
        return $this->helper;
    }

    public function setHelper($helper): self
    {
        $this->helper = $helper;
    }
}
