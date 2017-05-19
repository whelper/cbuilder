<?php  echo '<?xml version="1.0" encoding="euc-kr"?>' . "\n"; ?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
 
    <channel>
     
    <title><?php echo xml_convert($feed_name); ?></title>
 
    <link><?php echo $feed_url; ?></link>
    <description><?php echo $page_description; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>
 
    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.samjintyre.com/" />
 
    <?php foreach($posts->result() as $post): ?>
        <item>
          <title><?php echo iconv('utf-8','euc-kr',$post->title); ?></title>
          <link><?php echo site_url('/front/board/view/id/17/no/'.$post->id) ?></link>
          <guid><?php echo site_url('/front/board/view/id/17/no/'.$post->id) ?></guid>
 
            <description><?php echo character_limiter(strip_tags(iconv('utf-8','euc-kr',$post->content)), 200); ?></description>
            <pubDate><?php echo $post->register_date; ?></pubDate>
        </item>
    <?php endforeach; ?>
     
    </channel>
</rss>
