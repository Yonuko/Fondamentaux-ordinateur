<?php
interface IRequest
{
    /**
     * Retrieves data from the request body
     * @return array
     */
    public function getBody();
}
