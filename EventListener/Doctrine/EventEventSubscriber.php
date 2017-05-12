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
use Miky\Bundle\CalendarBundle\Model\Event;

class EventEventSubscriber implements EventSubscriber
{
    protected $agendaClass;

    /**
     * AgendaEventSubscriber constructor.
     */
    public function __construct(string $agendaClass)
    {
        $this->agendaClass = $agendaClass;
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
        if (!is_subclass_of($metadata->getName(), Event::class)) {
            return;
        }
        $builder = new ClassMetadataBuilder($metadata);
        $builder->createManyToOne("agenda", $this->agendaClass)
            ->mappedBy("events")
            ->addJoinColumn("agenda_id", "id")->build();
    }

}