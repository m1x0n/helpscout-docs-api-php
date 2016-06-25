<?php
namespace HelpScoutDocs;

use ArrayAccess;
use ArrayIterator;
use Countable;
use SeekableIterator;

class ResourceCollection implements ArrayAccess, SeekableIterator, Countable {
    
    private $page  = 0;
    private $pages = 0;
    private $count = 0;
    private $items = null;

    public function __construct($data, $itemType) {
        if ($data) {
            $this->page  = $data->page;
            $this->pages = $data->pages;
            $this->count = $data->count;

            $items = $data->items;
            if ($items) {
                $this->items = new ArrayIterator();

                foreach($items as $index => $item) {
                    $this->items->append(new $itemType($item));
                    unset($items[$index]);
                }
            }
            unset($data);
        }
    }

    /**
     * @return boolean
     */
    public function hasNextPage() {
        return $this->page < $this->pages;
    }

    /**
     * @return boolean
     */
    public function hasPrevPage() {
        return $this->page > 1;
    }

    /**
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->items->current();
    }

    public function next()
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

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->items->valid();
    }

    public function rewind()
    {
        $this->items->rewind();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
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

    public function offsetSet($offset, $value)
    {
        $this->items->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->items->offsetUnset($offset);
    }

    public function count()
    {
        return $this->items->count();
    }

    public function seek($position)
    {
        $this->items->seek($position);
    }
}
