<?php

class Post_Iterator implements Iterator
{
    private $wpQuery;
    /**
     * @var string
     */
    private $query;

    public function __construct($query = '')
    {
//        print_r(__METHOD__);
        if ('' == $query) {
            global $wp_query;
            $this->wpQuery = &$wp_query;
        } else {
            $this->wpQuery = new WP_Query($query);
        }
        $this->query = $query;
    }

    public function valid()
    {
        $valid = $this->wpQuery->have_posts();
        if (!$valid && null !== $this->query) {
            wp_reset_postdata();
        }
        // if it is a custom query and there is no more posts use wp_reset_postdata()
//        print_r(__METHOD__);
        return $valid;
    }

    public function current()
    {
//        print_r(__METHOD__);
        global $post;
        $this->wpQuery->the_post();
//        return new \Whipster\core\WPHipsterPost($post);
        return $post;
    }

    public function next()
    {
//        print_r(__METHOD__);
    }

    public function rewind()
    {
//        print_r(__METHOD__);
        $this->wpQuery->rewind_posts();
    }

    public function key()
    {
//        print_r(__METHOD__);
        return the_title('', '', false);
    }
}