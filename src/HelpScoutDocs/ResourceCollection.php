<?php

declare(strict_types=1);

namespace HelpScoutDocs;

use ArrayAccess;
use ArrayIterator;
use Countable;
use HelpScoutDocs\Models\DocsModel;
use SeekableIterator;
use stdClass;

class ResourceCollection implements ArrayAccess, SeekableIterator, Countable
{
    private int $page  = 0;
    private int $pages = 0;
    private int $count = 0;
    /**
     * @var ArrayIterator<int, DocsModel>
     */
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
                    $this->items->append(new $itemType((object)$item));
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

    /**
     * @return ArrayIterator<int, DocsModel>
     */
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

    public function current(): mixed
    {
        return $this->items->current();
    }

    public function next(): void
    {
        $this->items->next();
    }

    public function key(): int
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

    public function offsetExists(mixed $offset): bool
    {
        return $this->items->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->items->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function seek(int $offset): void
    {
        $this->items->seek($offset);
    }
}
