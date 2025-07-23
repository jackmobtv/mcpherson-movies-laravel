<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Models\shared\Validators;
use DateTime;
use InvalidArgumentException;

#[AllowDynamicProperties]
class CustomUser
{
    private int $userId;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $password;
    private string $language;
    private string $status;
    private string $privileges;
    private DateTime $createdAt;
    private string $timezone;
    private DateTime $dateofbirth;
    private string $pronouns;
    private string $description;

    public function __construct(){}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if(!Validators::isValidEmail($email)){
            throw new InvalidArgumentException("Invalid email");
        }
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        if(!Validators::isValidPhone($phone)){
            throw new InvalidArgumentException("Invalid phone");
        }
        $this->phone = $phone;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPrivileges(): string
    {
        return $this->privileges;
    }

    public function setPrivileges(string $privileges): void
    {
        $this->privileges = $privileges;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function getDateofbirth(): DateTime
    {
        return $this->dateofbirth;
    }

    public function setDateofbirth(DateTime $dateofbirth): void
    {
        $this->dateofbirth = $dateofbirth;
    }

    public function getPronouns(): string
    {
        return $this->pronouns;
    }

    public function setPronouns(string $pronouns): void
    {
        $this->pronouns = $pronouns;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
