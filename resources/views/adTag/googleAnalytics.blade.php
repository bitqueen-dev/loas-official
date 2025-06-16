<!-- GoogleAnalytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85680179-1', 'auto');
  ga('send', 'pageview');

  function gaClicks(category,action,label,value) {
    if(category == ''){category='other';}
    if(action == ''){action='click';}
    if(label == ''){label='other';}
    if(value){ // int
      ga('send','event',category,action,label,value);
    } else {
      ga('send','event',category,action,label);
    }
  }
</script>