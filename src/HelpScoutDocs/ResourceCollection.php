<?php

declare(strict_types=1);

namespace HelpScoutDocs;

use ArrayAccess;
use ArrayIterator;
use Countable;
use SeekableIterator;
use stdClass;

class ResourceCollection implements ArrayAccess, SeekableIterator, Countable
{
    private int $page  = 0;
    private int $pages = 0;
    private int $count = 0;
    private ArrayIterator $items;

    public function __construct(?stdClass $data, string $itemType)
    {
        if (!$data) {
            $this->items = new ArrayIterator();
        } else {
            $this->page  = $data->page;
            $this->pages = $data->pages;
            $this->count = $data->count;

            $items = $data->items;
            if ($items) {
                $this->items = new ArrayIterator();

                foreach ($items as $index => $item) {
                    $this->items->append(new $itemType($item));
                    unset($items[$index]);
                }
            }
        }
    }

    public function hasNextPage(): bool
    {
        return $this->page < $this->pages;
    }

    public function hasPrevPage(): bool
    {
        return $this->page > 1;
    }

    public function getItems(): ArrayIterator
    {
        return $this->items;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->items->current();
    }

    public function next(): void
    {
        $this->items->next();
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->items->key();
    }

    public function valid(): bool
    {
        return $this->items->valid();
    }

    public function rewind(): void
    {
        $this->items->rewind();
    }

    /**
     * @param mixed $offset
     */
    public function offsetExists($offset): bool
    {
        return $this->items->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->items->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->items->offsetUnset($offset);
    }

    public function count()
    {
        return $this->items->count();
    }

    public function seek($offset): void
    {
        $this->items->seek($offset);
    }
}
