<?php


namespace App\EventListener;


use App\Entity\Notificacao;
use App\Entity\PostComentario;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogComentarioSubscriber extends AbstractController implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->notificacao('persist', $args);
    }

    private function notificacao(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof PostComentario) {
            return;
        }

        $log = new Notificacao();
        $entityManager = $args->getObjectManager();
        $log->setNome('Comentario');
        $log->setDescricao('comentou um post');
        $log->setUser($this->getUser());
        $entityManager->persist($log);
        $entityManager->flush();
    }
}