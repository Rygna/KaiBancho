<?php

namespace App\Libraries\PhpBinaryReader\Type;

use App\Libraries\PhpBinaryReader\BinaryReader;
use App\Libraries\PhpBinaryReader\Exception\InvalidDataException;

class Byte implements TypeInterface
{
    /**
     * Returns an variable number of bytes
     *
     * @param  \App\Libraries\PhpBinaryReader\BinaryReader $br
     * @param  int|null                      $length
     * @return string
     * @throws \OutOfBoundsException
     * @throws InvalidDataException
     */
    public function read(BinaryReader &$br, $length = null)
    {
        if (!is_int($length)) {
            throw new InvalidDataException('The length parameter must be an integer');
        }
        $br->align();
        if (!$br->canReadBytes($length)) {
            throw new \OutOfBoundsException('Cannot read bytes, it exceeds the boundary of the file');
        }
        $segment = $br->readFromHandle($length);
        return $segment;
    }
}
