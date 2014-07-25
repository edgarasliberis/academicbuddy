<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AB\UserBundle\Doctrine\Orm;

use AB\Bundle\Entity\Mentor;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Doctrine\Orm\UserListener as BaseListener;

class UserListener extends BaseListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist($args)
    {
        $object = $args->getEntity();
        if ($object instanceof UserInterface) {
            $this->updateMentorRelationships($object);
//            if ($object instanceof Mentor) $this->updateMentorRelationships($object);
            $this->updateUserFields($object);

        }
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate($args)
    {
        $object = $args->getEntity();
        if ($object instanceof UserInterface) {
            $this->updateUserFields($object);
            // We are doing a update, so we must force Doctrine to update the
            // changeset in case we changed something above
            $em   = $args->getEntityManager();
            $uow  = $em->getUnitOfWork();
            $meta = $em->getClassMetadata(get_class($object));
            $uow->recomputeSingleEntityChangeSet($meta, $object);
        }
    }

    private function updateMentorRelationships(UserInterface $user) {
        $user->setFirstName("WORKING");
        foreach ($user->getCourses() as $course) {
            $user->removeCourse($course);
            $course->setMentor($user);
            $user->addCourse($course);
        }
    }
}
