<?php


namespace App\Traits;

/**
 * @package App\Traits
 */
trait GetFullName {
    /**
     * Получить полное имя
     * @return string|null
     */
    public function getFullName(): ?string {
        return $this->lastname . ' ' . $this->firstname;
    }
}
