<?php
require_once ('blogpost.php');

class Tags extends Database {
    public function resultset() {
        $posts = parent::resultset();

        if (is_array($posts) && count($posts)) {
            foreach ($posts as &$post) {
                $tags = [];

                $sql = 'SELECT t.name FROM blog_posts_tags bpt LEFT JOIN tags t ON bpt.tag_id = i.id WHERE bpt.id = blog_id';

                parent::query($sql);
                parent::bind(':blogid', $posts['id']);
                $blogTags = parent::resultset();

                foreach ($blogTags as $btag) {
                    array_push($tags, $btag['name']);
                }
                $post['tags'] = implode(',', $tags);
            }
            return $posts;
        }else{
            return [];
        }
    }
}
?>