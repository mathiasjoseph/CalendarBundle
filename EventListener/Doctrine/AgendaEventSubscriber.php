<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 11/05/17
 * Time: 10:11
 */

namespace Miky\Bundle\CalendarBundle\EventListener\Doctrine;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Miky\Bundle\CalendarBundle\Model\Agenda;

class AgendaEventSubscriber implements EventSubscriber
{

    protected $eventClass;

    /**
     * AgendaEventSubscriber constructor.
     */
    public function __construct(string $eventClass)
    {
        $this->eventClass = $eventClass;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();
        if (!is_subclass_of($metadata->getName(), Agenda::class)) {
            return;
        }
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createOneToMany("events", $this->eventClass)
            ->cascadeAll()
            ->mappedBy("agenda")
            ->build();

    }
}