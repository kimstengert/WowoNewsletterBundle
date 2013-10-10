<?php

namespace Wowo\NewsletterBundle\Newsletter\Model;

use Wowo\NewsletterBundle\Newsletter\Model\Exception\ContactNotFoundException;
use Symfony\Component\Form\FormTypeInterface;

class ContactManager extends AbstractManager implements ContactManagerInterface
{
    /**
    * findContactToChooseForMailing
    *
    * @access public
    * @return Contact[]
    */
    public function findContactToChooseForMailing()
    {
        $contacts = $this->em->getRepository($this->class)->findAll();
        $result   = array();
        foreach ($contacts as $contact) {
            $result[$contact->getId()] = (string) $contact;
        }

        return $result;
    }

    /**
    * findContactForMailingFromRequest
    *
    * @access public
    * @return array
    */
    public function findChoosenContactIdForMailing(FormTypeInterface $form)
    {
        $data = $form->getData();

        return $data['contacts'];
    }

    /**
     * findContact
     *
     * @param mixed $id
     * @param mixed $class
     * @access public
     * @return Contact
     */
    public function findContact($id, $class)
    {
        $contact = $this
            ->em
            ->getRepository($class)
            ->find($id);
        if (!$contact) {
            throw new ContactNotFoundException(sprintf('Contact %s with id %d not found', $class, $id));
        }

        return $contact;
    }
}
