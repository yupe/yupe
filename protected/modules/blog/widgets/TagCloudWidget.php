<?php
class TagCloudWidget extends YWidget
{
    public function run()
    {
        $tags = Post::model()->getAllTagsWithModelsCount();

        $total = 0;

        foreach($tags as $tag)
            $total += $tag['count'];

        $outtags = array();

        if($total > 0)
        {
            foreach($tags as $tag)
                $outtags[$tag['name']] = 8 + (int) (16 * $tag['count'] / ($total + 10));
            ksort($outtags);
        }

        $this->render('tagcloud', array('tags' => $outtags));
    }
}
