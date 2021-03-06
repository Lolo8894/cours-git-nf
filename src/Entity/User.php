<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender", orphanRemoval=true)
     */
    private $messagesSender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="receiver", orphanRemoval=true)
     */
    private $messageReceiver;

    public function __construct()
    {
        $this->messagesSender = new ArrayCollection();
        $this->messageReceiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesSender(): Collection
    {
        return $this->messagesSender;
    }

    public function addMessagesSender(Message $messagesSender): self
    {
        if (!$this->messagesSender->contains($messagesSender)) {
            $this->messagesSender[] = $messagesSender;
            $messagesSender->setSender($this);
        }

        return $this;
    }

    public function removeMessagesSender(Message $messagesSender): self
    {
        if ($this->messagesSender->contains($messagesSender)) {
            $this->messagesSender->removeElement($messagesSender);
            // set the owning side to null (unless already changed)
            if ($messagesSender->getSender() === $this) {
                $messagesSender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessageReceiver(): Collection
    {
        return $this->messageReceiver;
    }

    public function addMessageReceiver(Message $messageReceiver): self
    {
        if (!$this->messageReceiver->contains($messageReceiver)) {
            $this->messageReceiver[] = $messageReceiver;
            $messageReceiver->setReceiver($this);
        }

        return $this;
    }

    public function removeMessageReceiver(Message $messageReceiver): self
    {
        if ($this->messageReceiver->contains($messageReceiver)) {
            $this->messageReceiver->removeElement($messageReceiver);
            // set the owning side to null (unless already changed)
            if ($messageReceiver->getReceiver() === $this) {
                $messageReceiver->setReceiver(null);
            }
        }

        return $this;
    }
}
