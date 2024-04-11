<?php

namespace services\contracts;

interface PostServiceInterface
{
    /**
     * Store new post.
     */
    public function store();

    /**
     * @return array
     */
    public function getPosts();

    /**
     * Display a specific resource.
     * 
     * @param int|string $id
     * @return object
     */
    public function show($id);

    /**
     * Update a specific resource.
     */
    public function update();

    /**
     * Delete a specific resource.
     */
    public function delete();
}
