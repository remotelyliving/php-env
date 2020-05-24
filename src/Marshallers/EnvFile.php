<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Marshallers;

use RemotelyLiving\PHPEnv\Exceptions;
use RemotelyLiving\PHPEnv\Interfaces;

final class EnvFile implements Interfaces\Marshaller
{
    private \SplFileObject $envFile;

    private function __construct(\SplFileObject $envFile)
    {
        $this->envFile = $envFile;
    }

    public function marshallIntoEnvironment(): void
    {
        $this->envFile->rewind();
        ;
        while ($line = $this->envFile->fgets()) {
            $trimmed = trim($line);
            if (!$trimmed) {
                continue;
            }

            \putenv($trimmed);
        }
    }

    public static function create(\SplFileObject $envFile): self
    {
        return new self($envFile);
    }

    public static function createFromPath(string $filePath): self
    {
        try {
            $envFile = new \SplFileObject($filePath, 'r');
        } catch (\Throwable $e) {
            throw Exceptions\RuntimeError::envFileNotFound($filePath);
        }

        return self::create($envFile);
    }
}
