
<div id="main-content" style="margin: 20px auto; text-align: center;">
  
  <h1>PHP Memory Usage Example</h1>
  
  
  <p class="memory">Current memory usage is [ <strong><?php echo size_to_str(memory_get_peak_usage(true)); ?></strong> ].</h2>
  
  
  <p>Refresh your browser <br>
    &mdash; <kbd>Cmd + r</kbd> (Mac) or <kbd>F5</kbd> (Windows)  &mdash; <br>
    quickly <strong>20 times and more</strong> and you'll see the memory usage remaining stable.
  </p>
  
  <style type="text/css" media="screen">
    p.memory { font-size: 200%; }
    p.memory strong { color: red; }
  </style>
  
</div>

