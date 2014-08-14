




<!DOCTYPE html>
<html lang="en" class="   ">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    
    
    <title>bootstrap-notify/bootstrap-notify.js at master · goodybag/bootstrap-notify</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub">
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png">
    <meta property="fb:app_id" content="1401488693436528">

      <meta content="@github" name="twitter:site" /><meta content="summary" name="twitter:card" /><meta content="goodybag/bootstrap-notify" name="twitter:title" /><meta content="bootstrap-notify - Bootstrap alert system made better, builds off of bootstrap-alert.js" name="twitter:description" /><meta content="https://avatars1.githubusercontent.com/u/812185?v=2&amp;s=400" name="twitter:image:src" />
<meta content="GitHub" property="og:site_name" /><meta content="object" property="og:type" /><meta content="https://avatars1.githubusercontent.com/u/812185?v=2&amp;s=400" property="og:image" /><meta content="goodybag/bootstrap-notify" property="og:title" /><meta content="https://github.com/goodybag/bootstrap-notify" property="og:url" /><meta content="bootstrap-notify - Bootstrap alert system made better, builds off of bootstrap-alert.js" property="og:description" />

    <link rel="assets" href="https://assets-cdn.github.com/">
    <link rel="conduit-xhr" href="https://ghconduit.com:25035">
    <link rel="xhr-socket" href="/_sockets">

    <meta name="msapplication-TileImage" content="/windows-tile.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="selected-link" value="repo_source" data-pjax-transient>
      <meta name="google-analytics" content="UA-3769691-2">

    <meta content="collector.githubapp.com" name="octolytics-host" /><meta content="collector-cdn.github.com" name="octolytics-script-host" /><meta content="github" name="octolytics-app-id" /><meta content="53950E07:4A6D:C2CEBF7:53EC7173" name="octolytics-dimension-request_id" /><meta content="668145" name="octolytics-actor-id" /><meta content="yupe" name="octolytics-actor-login" /><meta content="703284607abb56df3e6917a583717793586c1fd48a42ca63a17b44fd8ee7f5cc" name="octolytics-actor-hash" />
    

    
    
    <link rel="icon" type="image/x-icon" href="https://assets-cdn.github.com/favicon.ico">


    <meta content="authenticity_token" name="csrf-param" />
<meta content="2esOURpo6BEHvhclqklKHNoUUbId+c5eSpnzahwQcbk3lplu9EMwX4BT73Kn8Ry/OCo0o12X0nz38Y3BOgEUeg==" name="csrf-token" />

    <link href="https://assets-cdn.github.com/assets/github-9292d024f6948334bdb496c5e7a55d8df86fb80e.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://assets-cdn.github.com/assets/github2-fe2778113a79ed0985eedf979a34188ceea23f97.css" media="all" rel="stylesheet" type="text/css" />
    


    <meta http-equiv="x-pjax-version" content="f4d07a70fe9c693bc8f53c5731e8976d">

      
  <meta name="description" content="bootstrap-notify - Bootstrap alert system made better, builds off of bootstrap-alert.js">


  <meta content="812185" name="octolytics-dimension-user_id" /><meta content="goodybag" name="octolytics-dimension-user_login" /><meta content="4659467" name="octolytics-dimension-repository_id" /><meta content="goodybag/bootstrap-notify" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="4659467" name="octolytics-dimension-repository_network_root_id" /><meta content="goodybag/bootstrap-notify" name="octolytics-dimension-repository_network_root_nwo" />

  <link href="https://github.com/goodybag/bootstrap-notify/commits/master.atom" rel="alternate" title="Recent Commits to bootstrap-notify:master" type="application/atom+xml">

  </head>


  <body class="logged_in  env-production linux vis-public page-blob">
    <a href="#start-of-content" tabindex="1" class="accessibility-aid js-skip-to-content">Skip to content</a>
    <div class="wrapper">
      
      
      
      


      <div class="header header-logged-in true">
  <div class="container clearfix">

    <a class="header-logo-invertocat" href="https://github.com/" aria-label="Homepage">
  <span class="mega-octicon octicon-mark-github"></span>
</a>


    
    <a href="/notifications" aria-label="You have unread notifications" class="notification-indicator tooltipped tooltipped-s" data-hotkey="g n">
        <span class="mail-status unread"></span>
</a>

      <div class="command-bar js-command-bar  in-repository">
          <form accept-charset="UTF-8" action="/search" class="command-bar-form" id="top_search_form" method="get">

<div class="commandbar">
  <span class="message"></span>
  <input type="text" data-hotkey="s, /" name="q" id="js-command-bar-field" placeholder="Search or type a command" tabindex="1" autocapitalize="off"
    
    data-username="yupe"
    data-repo="goodybag/bootstrap-notify"
  >
  <div class="display hidden"></div>
</div>

    <input type="hidden" name="nwo" value="goodybag/bootstrap-notify">

    <div class="select-menu js-menu-container js-select-menu search-context-select-menu">
      <span class="minibutton select-menu-button js-menu-target" role="button" aria-haspopup="true">
        <span class="js-select-button">This repository</span>
      </span>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container" aria-hidden="true">
        <div class="select-menu-modal">

          <div class="select-menu-item js-navigation-item js-this-repository-navigation-item selected">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" class="js-search-this-repository" name="search_target" value="repository" checked="checked">
            <div class="select-menu-item-text js-select-button-text">This repository</div>
          </div> <!-- /.select-menu-item -->

          <div class="select-menu-item js-navigation-item js-all-repositories-navigation-item">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" name="search_target" value="global">
            <div class="select-menu-item-text js-select-button-text">All repositories</div>
          </div> <!-- /.select-menu-item -->

        </div>
      </div>
    </div>

  <span class="help tooltipped tooltipped-s" aria-label="Show command bar help">
    <span class="octicon octicon-question"></span>
  </span>


  <input type="hidden" name="ref" value="cmdform">

</form>
        <ul class="top-nav">
          <li class="explore"><a href="/explore">Explore</a></li>
            <li><a href="https://gist.github.com">Gist</a></li>
            <li><a href="/blog">Blog</a></li>
          <li><a href="https://help.github.com">Help</a></li>
        </ul>
      </div>

    

<ul id="user-links">
  <li>
    <a href="/yupe" class="name">
      <img alt="Yupe! team" data-user="668145" height="20" src="https://avatars1.githubusercontent.com/u/668145?v=2&amp;s=40" width="20" /> yupe
    </a>
  </li>

  <li class="new-menu dropdown-toggle js-menu-container">
    <a href="#" class="js-menu-target tooltipped tooltipped-s" aria-label="Create new...">
      <span class="octicon octicon-plus"></span>
      <span class="dropdown-arrow"></span>
    </a>

    <div class="new-menu-content js-menu-content">
    </div>
  </li>

  <li>
    <a href="/settings/profile" id="account_settings"
      class="tooltipped tooltipped-s"
      aria-label="Account settings ">
      <span class="octicon octicon-tools"></span>
    </a>
  </li>
  <li>
    <form accept-charset="UTF-8" action="/logout" class="logout-form" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="/Elmq6zAztrEmooWaMu9c6LIDbWDuimkFqs9icnEHWMfpJfkhyyWsQKRj1amGD1gYiBedrxQ2veX0chmiSuYPA==" /></div>
      <button class="sign-out-button tooltipped tooltipped-s" aria-label="Sign out">
        <span class="octicon octicon-sign-out"></span>
      </button>
</form>  </li>

</ul>

<div class="js-new-dropdown-contents hidden">
  

<ul class="dropdown-menu">
  <li>
    <a href="/new"><span class="octicon octicon-repo"></span> New repository</a>
  </li>
  <li>
    <a href="https://porter.github.com/new"><span class="octicon octicon-move-right"></span> Import repository</a>
  </li>
  <li>
    <a href="/organizations/new"><span class="octicon octicon-organization"></span> New organization</a>
  </li>


    <li class="section-title">
      <span title="goodybag/bootstrap-notify">This repository</span>
    </li>
      <li>
        <a href="/goodybag/bootstrap-notify/issues/new"><span class="octicon octicon-issue-opened"></span> New issue</a>
      </li>
</ul>

</div>


    
  </div>
</div>

      

        



      <div id="start-of-content" class="accessibility-aid"></div>
          <div class="site" itemscope itemtype="http://schema.org/WebPage">
    <div id="js-flash-container">
      
    </div>
    <div class="pagehead repohead instapaper_ignore readability-menu">
      <div class="container">
        
<ul class="pagehead-actions">

    <li class="subscription">
      <form accept-charset="UTF-8" action="/notifications/subscribe" class="js-social-container" data-autosubmit="true" data-remote="true" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="HZcqrxaybTcSOePBxN6LCoTtv1cTn/2K6BA6u4PNchgawQ/bIPXCsTo4sSX34FG1T2FFwdgEGReEBcbt7t/8lA==" /></div>  <input id="repository_id" name="repository_id" type="hidden" value="4659467" />

    <div class="select-menu js-menu-container js-select-menu">
      <a class="social-count js-social-count" href="/goodybag/bootstrap-notify/watchers">
        84
      </a>
      <a href="/goodybag/bootstrap-notify/subscription"
        class="minibutton select-menu-button with-count js-menu-target" role="button" tabindex="0" aria-haspopup="true">
        <span class="js-select-button">
          <span class="octicon octicon-eye"></span>
          Watch
        </span>
      </a>

      <div class="select-menu-modal-holder">
        <div class="select-menu-modal subscription-menu-modal js-menu-content" aria-hidden="true">
          <div class="select-menu-header">
            <span class="select-menu-title">Notifications</span>
            <span class="octicon octicon-x js-menu-close" role="button" aria-label="Close"></span>
          </div> <!-- /.select-menu-header -->

          <div class="select-menu-list js-navigation-container" role="menu">

            <div class="select-menu-item js-navigation-item selected" role="menuitem" tabindex="0">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input checked="checked" id="do_included" name="do" type="radio" value="included" />
                <h4>Not watching</h4>
                <span class="description">Be notified when participating or @mentioned.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-eye"></span>
                  Watch
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

            <div class="select-menu-item js-navigation-item " role="menuitem" tabindex="0">
              <span class="select-menu-item-icon octicon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input id="do_subscribed" name="do" type="radio" value="subscribed" />
                <h4>Watching</h4>
                <span class="description">Be notified of all conversations.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-eye"></span>
                  Unwatch
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

            <div class="select-menu-item js-navigation-item " role="menuitem" tabindex="0">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input id="do_ignore" name="do" type="radio" value="ignore" />
                <h4>Ignoring</h4>
                <span class="description">Never be notified.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-mute"></span>
                  Stop ignoring
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

          </div> <!-- /.select-menu-list -->

        </div> <!-- /.select-menu-modal -->
      </div> <!-- /.select-menu-modal-holder -->
    </div> <!-- /.select-menu -->

</form>
    </li>

  <li>
    

  <div class="js-toggler-container js-social-container starring-container ">

    <form accept-charset="UTF-8" action="/goodybag/bootstrap-notify/unstar" class="js-toggler-form starred js-unstar-button" data-remote="true" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="9tLOv6LEScavc7dYQUXOArvV7jdL7ljZohmShUjAr5niksTIufshulO1tC5xNWWkwsGf5gj8ULSz2eH1tl7ysA==" /></div>
      <button
        class="minibutton with-count js-toggler-target star-button"
        aria-label="Unstar this repository" title="Unstar goodybag/bootstrap-notify">
        <span class="octicon octicon-star"></span>
        Unstar
      </button>
        <a class="social-count js-social-count" href="/goodybag/bootstrap-notify/stargazers">
          638
        </a>
</form>
    <form accept-charset="UTF-8" action="/goodybag/bootstrap-notify/star" class="js-toggler-form unstarred js-star-button" data-remote="true" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="FAtWcclIriobKMUZn3lWA0W8GFcnPaZL7RqOhCRxlBlmj9No40dcfkCXNFUKVKVB7EAQKhDpTLwUn0otDoW28w==" /></div>
      <button
        class="minibutton with-count js-toggler-target star-button"
        aria-label="Star this repository" title="Star goodybag/bootstrap-notify">
        <span class="octicon octicon-star"></span>
        Star
      </button>
        <a class="social-count js-social-count" href="/goodybag/bootstrap-notify/stargazers">
          638
        </a>
</form>  </div>

  </li>


        <li>
          <a href="/goodybag/bootstrap-notify/fork" class="minibutton with-count js-toggler-target fork-button lighter tooltipped-n" title="Fork your own copy of goodybag/bootstrap-notify to your account" aria-label="Fork your own copy of goodybag/bootstrap-notify to your account" rel="facebox nofollow">
            <span class="octicon octicon-repo-forked"></span>
            Fork
          </a>
          <a href="/goodybag/bootstrap-notify/network" class="social-count">214</a>
        </li>

</ul>

        <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
          <span class="mega-octicon octicon-repo"></span>
          <span class="author"><a href="/goodybag" class="url fn" itemprop="url" rel="author"><span itemprop="title">goodybag</span></a></span><!--
       --><span class="path-divider">/</span><!--
       --><strong><a href="/goodybag/bootstrap-notify" class="js-current-repository js-repo-home-link">bootstrap-notify</a></strong>

          <span class="page-context-loader">
            <img alt="" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
          </span>

        </h1>
      </div><!-- /.container -->
    </div><!-- /.repohead -->

    <div class="container">
      <div class="repository-with-sidebar repo-container new-discussion-timeline  ">
        <div class="repository-sidebar clearfix">
            

<div class="sunken-menu vertical-right repo-nav js-repo-nav js-repository-container-pjax js-octicon-loaders" data-issue-count-url="/goodybag/bootstrap-notify/issues/counts">
  <div class="sunken-menu-contents">
    <ul class="sunken-menu-group">
      <li class="tooltipped tooltipped-w" aria-label="Code">
        <a href="/goodybag/bootstrap-notify" aria-label="Code" class="selected js-selected-navigation-item sunken-menu-item" data-hotkey="g c" data-pjax="true" data-selected-links="repo_source repo_downloads repo_commits repo_releases repo_tags repo_branches /goodybag/bootstrap-notify">
          <span class="octicon octicon-code"></span> <span class="full-word">Code</span>
          <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

        <li class="tooltipped tooltipped-w" aria-label="Issues">
          <a href="/goodybag/bootstrap-notify/issues" aria-label="Issues" class="js-selected-navigation-item sunken-menu-item js-disable-pjax" data-hotkey="g i" data-selected-links="repo_issues repo_labels repo_milestones /goodybag/bootstrap-notify/issues">
            <span class="octicon octicon-issue-opened"></span> <span class="full-word">Issues</span>
            <span class="js-issue-replace-counter"></span>
            <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>

      <li class="tooltipped tooltipped-w" aria-label="Pull Requests">
        <a href="/goodybag/bootstrap-notify/pulls" aria-label="Pull Requests" class="js-selected-navigation-item sunken-menu-item js-disable-pjax" data-hotkey="g p" data-selected-links="repo_pulls /goodybag/bootstrap-notify/pulls">
            <span class="octicon octicon-git-pull-request"></span> <span class="full-word">Pull Requests</span>
            <span class="js-pull-replace-counter"></span>
            <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>


        <li class="tooltipped tooltipped-w" aria-label="Wiki">
          <a href="/goodybag/bootstrap-notify/wiki" aria-label="Wiki" class="js-selected-navigation-item sunken-menu-item js-disable-pjax" data-hotkey="g w" data-selected-links="repo_wiki /goodybag/bootstrap-notify/wiki">
            <span class="octicon octicon-book"></span> <span class="full-word">Wiki</span>
            <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>
    </ul>
    <div class="sunken-menu-separator"></div>
    <ul class="sunken-menu-group">

      <li class="tooltipped tooltipped-w" aria-label="Pulse">
        <a href="/goodybag/bootstrap-notify/pulse" aria-label="Pulse" class="js-selected-navigation-item sunken-menu-item" data-pjax="true" data-selected-links="pulse /goodybag/bootstrap-notify/pulse">
          <span class="octicon octicon-pulse"></span> <span class="full-word">Pulse</span>
          <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

      <li class="tooltipped tooltipped-w" aria-label="Graphs">
        <a href="/goodybag/bootstrap-notify/graphs" aria-label="Graphs" class="js-selected-navigation-item sunken-menu-item" data-pjax="true" data-selected-links="repo_graphs repo_contributors /goodybag/bootstrap-notify/graphs">
          <span class="octicon octicon-graph"></span> <span class="full-word">Graphs</span>
          <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>
    </ul>


  </div>
</div>

              <div class="only-with-full-nav">
                

  

<div class="clone-url open"
  data-protocol-type="http"
  data-url="/users/set_protocol?protocol_selector=http&amp;protocol_type=clone">
  <h3><strong>HTTPS</strong> clone URL</h3>
  <div class="input-group">
    <input type="text" class="input-mini input-monospace js-url-field"
           value="https://github.com/goodybag/bootstrap-notify.git" readonly="readonly">
    <span class="input-group-button">
      <button aria-label="Copy to clipboard" class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="https://github.com/goodybag/bootstrap-notify.git" data-copied-hint="Copied!" type="button"><span class="octicon octicon-clippy"></span></button>
    </span>
  </div>
</div>

  

<div class="clone-url "
  data-protocol-type="ssh"
  data-url="/users/set_protocol?protocol_selector=ssh&amp;protocol_type=clone">
  <h3><strong>SSH</strong> clone URL</h3>
  <div class="input-group">
    <input type="text" class="input-mini input-monospace js-url-field"
           value="git@github.com:goodybag/bootstrap-notify.git" readonly="readonly">
    <span class="input-group-button">
      <button aria-label="Copy to clipboard" class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="git@github.com:goodybag/bootstrap-notify.git" data-copied-hint="Copied!" type="button"><span class="octicon octicon-clippy"></span></button>
    </span>
  </div>
</div>

  

<div class="clone-url "
  data-protocol-type="subversion"
  data-url="/users/set_protocol?protocol_selector=subversion&amp;protocol_type=clone">
  <h3><strong>Subversion</strong> checkout URL</h3>
  <div class="input-group">
    <input type="text" class="input-mini input-monospace js-url-field"
           value="https://github.com/goodybag/bootstrap-notify" readonly="readonly">
    <span class="input-group-button">
      <button aria-label="Copy to clipboard" class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="https://github.com/goodybag/bootstrap-notify" data-copied-hint="Copied!" type="button"><span class="octicon octicon-clippy"></span></button>
    </span>
  </div>
</div>


<p class="clone-options">You can clone with
      <a href="#" class="js-clone-selector" data-protocol="http">HTTPS</a>,
      <a href="#" class="js-clone-selector" data-protocol="ssh">SSH</a>,
      or <a href="#" class="js-clone-selector" data-protocol="subversion">Subversion</a>.
  <a href="https://help.github.com/articles/which-remote-url-should-i-use" class="help tooltipped tooltipped-n" aria-label="Get help on which URL is right for you.">
    <span class="octicon octicon-question"></span>
  </a>
</p>



                <a href="/goodybag/bootstrap-notify/archive/master.zip"
                   class="minibutton sidebar-button"
                   aria-label="Download goodybag/bootstrap-notify as a zip file"
                   title="Download goodybag/bootstrap-notify as a zip file"
                   rel="nofollow">
                  <span class="octicon octicon-cloud-download"></span>
                  Download ZIP
                </a>
              </div>
        </div><!-- /.repository-sidebar -->

        <div id="js-repo-pjax-container" class="repository-content context-loader-container" data-pjax-container>
          


<a href="/goodybag/bootstrap-notify/blob/581e53e0a2a897a39766d13e37cc7f613f48ee8a/js/bootstrap-notify.js" class="hidden js-permalink-shortcut" data-hotkey="y">Permalink</a>

<!-- blob contrib key: blob_contributors:v21:3a4e33a747757dfe4fa54f2abc6df930 -->

<div class="file-navigation">
  

<div class="select-menu js-menu-container js-select-menu left">
  <span class="minibutton select-menu-button js-menu-target css-truncate" data-hotkey="w"
    data-master-branch="master"
    data-ref="master"
    title="master"
    role="button" aria-label="Switch branches or tags" tabindex="0" aria-haspopup="true">
    <span class="octicon octicon-git-branch"></span>
    <i>branch:</i>
    <span class="js-select-button css-truncate-target">master</span>
  </span>

  <div class="select-menu-modal-holder js-menu-content js-navigation-container" data-pjax aria-hidden="true">

    <div class="select-menu-modal">
      <div class="select-menu-header">
        <span class="select-menu-title">Switch branches/tags</span>
        <span class="octicon octicon-x js-menu-close" role="button" aria-label="Close"></span>
      </div> <!-- /.select-menu-header -->

      <div class="select-menu-filters">
        <div class="select-menu-text-filter">
          <input type="text" aria-label="Filter branches/tags" id="context-commitish-filter-field" class="js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
        </div>
        <div class="select-menu-tabs">
          <ul>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="branches" class="js-select-menu-tab">Branches</a>
            </li>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="tags" class="js-select-menu-tab">Tags</a>
            </li>
          </ul>
        </div><!-- /.select-menu-tabs -->
      </div><!-- /.select-menu-filters -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="branches">

        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/goodybag/bootstrap-notify/blob/gh-pages/js/bootstrap-notify.js"
                 data-name="gh-pages"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="gh-pages">gh-pages</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item selected">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/goodybag/bootstrap-notify/blob/master/js/bootstrap-notify.js"
                 data-name="master"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="master">master</a>
            </div> <!-- /.select-menu-item -->
        </div>

          <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="tags">
        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/goodybag/bootstrap-notify/tree/0.1.0/js/bootstrap-notify.js"
                 data-name="0.1.0"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="0.1.0">0.1.0</a>
            </div> <!-- /.select-menu-item -->
        </div>

        <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

    </div> <!-- /.select-menu-modal -->
  </div> <!-- /.select-menu-modal-holder -->
</div> <!-- /.select-menu -->

  <div class="button-group right">
    <a href="/goodybag/bootstrap-notify/find/master"
          class="js-show-file-finder minibutton empty-icon tooltipped tooltipped-s"
          data-pjax
          data-hotkey="t"
          aria-label="Quickly jump between files">
      <span class="octicon octicon-list-unordered"></span>
    </a>
    <button class="js-zeroclipboard minibutton zeroclipboard-button"
          data-clipboard-text="js/bootstrap-notify.js"
          aria-label="Copy to clipboard"
          data-copied-hint="Copied!">
      <span class="octicon octicon-clippy"></span>
    </button>
  </div>

  <div class="breadcrumb">
    <span class='repo-root js-repo-root'><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/goodybag/bootstrap-notify" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">bootstrap-notify</span></a></span></span><span class="separator"> / </span><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/goodybag/bootstrap-notify/tree/master/js" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">js</span></a></span><span class="separator"> / </span><strong class="final-path">bootstrap-notify.js</strong>
  </div>
</div>


  <div class="commit file-history-tease">
      <img alt="Ernesto Alejo" class="main-avatar" data-user="961966" height="24" src="https://avatars2.githubusercontent.com/u/961966?v=2&amp;s=48" width="24" />
      <span class="author"><a href="/ernestoalejo" rel="contributor">ernestoalejo</a></span>
      <time datetime="2014-07-29T21:41:58+02:00" is="relative-time">July 29, 2014</time>
      <div class="commit-title">
          <a href="/goodybag/bootstrap-notify/commit/40121327180a52128a814c70932f11fe80b9e0d7" class="message" data-pjax="true" title="Add braces to conditionals to fix some errors.">Add braces to conditionals to fix some errors.</a>
      </div>

    <div class="participation">
      <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>7</strong>  contributors</a></p>
      
    <a class="avatar tooltipped tooltipped-s" aria-label="Laboratory" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=Laboratory"><img alt="Vitaly" data-user="1676506" height="20" src="https://avatars3.githubusercontent.com/u/1676506?v=2&amp;s=40" width="20" /></a>
    <a class="avatar tooltipped tooltipped-s" aria-label="lalitkapoor" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=lalitkapoor"><img alt="Lalit Kapoor" data-user="140436" height="20" src="https://avatars3.githubusercontent.com/u/140436?v=2&amp;s=40" width="20" /></a>
    <a class="avatar tooltipped tooltipped-s" aria-label="younes0" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=younes0"><img alt="Younès" data-user="886042" height="20" src="https://avatars2.githubusercontent.com/u/886042?v=2&amp;s=40" width="20" /></a>
    <a class="avatar tooltipped tooltipped-s" aria-label="Nijikokun" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=Nijikokun"><img alt="Nijiko Yonskai" data-user="198276" height="20" src="https://avatars3.githubusercontent.com/u/198276?v=2&amp;s=40" width="20" /></a>
    <a class="avatar tooltipped tooltipped-s" aria-label="gcirne" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=gcirne"><img alt="Guilherme Cirne" data-user="41139" height="20" src="https://avatars1.githubusercontent.com/u/41139?v=2&amp;s=40" width="20" /></a>
    <a class="avatar tooltipped tooltipped-s" aria-label="ernestoalejo" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=ernestoalejo"><img alt="Ernesto Alejo" data-user="961966" height="20" src="https://avatars0.githubusercontent.com/u/961966?v=2&amp;s=40" width="20" /></a>
    <a class="avatar tooltipped tooltipped-s" aria-label="cbou" href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js?author=cbou"><img alt="charles bourasseau" data-user="611389" height="20" src="https://avatars3.githubusercontent.com/u/611389?v=2&amp;s=40" width="20" /></a>


    </div>
    <div id="blob_contributors_box" style="display:none">
      <h2 class="facebox-header">Users who have contributed to this file</h2>
      <ul class="facebox-user-list">
          <li class="facebox-user-list-item">
            <img alt="Vitaly" data-user="1676506" height="24" src="https://avatars1.githubusercontent.com/u/1676506?v=2&amp;s=48" width="24" />
            <a href="/Laboratory">Laboratory</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="Lalit Kapoor" data-user="140436" height="24" src="https://avatars1.githubusercontent.com/u/140436?v=2&amp;s=48" width="24" />
            <a href="/lalitkapoor">lalitkapoor</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="Younès" data-user="886042" height="24" src="https://avatars0.githubusercontent.com/u/886042?v=2&amp;s=48" width="24" />
            <a href="/younes0">younes0</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="Nijiko Yonskai" data-user="198276" height="24" src="https://avatars1.githubusercontent.com/u/198276?v=2&amp;s=48" width="24" />
            <a href="/Nijikokun">Nijikokun</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="Guilherme Cirne" data-user="41139" height="24" src="https://avatars3.githubusercontent.com/u/41139?v=2&amp;s=48" width="24" />
            <a href="/gcirne">gcirne</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="Ernesto Alejo" data-user="961966" height="24" src="https://avatars2.githubusercontent.com/u/961966?v=2&amp;s=48" width="24" />
            <a href="/ernestoalejo">ernestoalejo</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="charles bourasseau" data-user="611389" height="24" src="https://avatars1.githubusercontent.com/u/611389?v=2&amp;s=48" width="24" />
            <a href="/cbou">cbou</a>
          </li>
      </ul>
    </div>
  </div>

<div class="file-box">
  <div class="file">
    <div class="meta clearfix">
      <div class="info file-name">
          <span>98 lines (85 sloc)</span>
          <span class="meta-divider"></span>
        <span>2.933 kb</span>
      </div>
      <div class="actions">
        <div class="button-group">
          <a href="/goodybag/bootstrap-notify/raw/master/js/bootstrap-notify.js" class="minibutton " id="raw-url">Raw</a>
            <a href="/goodybag/bootstrap-notify/blame/master/js/bootstrap-notify.js" class="minibutton js-update-url-with-hash">Blame</a>
          <a href="/goodybag/bootstrap-notify/commits/master/js/bootstrap-notify.js" class="minibutton " rel="nofollow">History</a>
        </div><!-- /.button-group -->


              <a class="octicon-button tooltipped tooltipped-n js-update-url-with-hash"
                 aria-label="Clicking this button will fork this project so you can edit the file"
                 href="/goodybag/bootstrap-notify/edit/master/js/bootstrap-notify.js"
                 data-method="post" rel="nofollow"><span class="octicon octicon-pencil"></span></a>

            <a class="octicon-button danger tooltipped tooltipped-s"
               href="/goodybag/bootstrap-notify/delete/master/js/bootstrap-notify.js"
               aria-label="Fork this project and delete file"
               data-method="post" data-test-id="delete-blob-file" rel="nofollow">
          <span class="octicon octicon-trashcan"></span>
        </a>
      </div><!-- /.actions -->
    </div>
      
  <div class="blob-wrapper data type-javascript">
      <table class="highlight tab-size-8 js-file-line-container">
      <tr>
        <td id="L1" class="blob-line-num js-line-number" data-line-number="1"></td>
        <td id="LC1" class="blob-line-code js-file-line"><span class="cm">/**</span></td>
      </tr>
      <tr>
        <td id="L2" class="blob-line-num js-line-number" data-line-number="2"></td>
        <td id="LC2" class="blob-line-code js-file-line"><span class="cm"> * bootstrap-notify.js v1.0</span></td>
      </tr>
      <tr>
        <td id="L3" class="blob-line-num js-line-number" data-line-number="3"></td>
        <td id="LC3" class="blob-line-code js-file-line"><span class="cm"> * --</span></td>
      </tr>
      <tr>
        <td id="L4" class="blob-line-num js-line-number" data-line-number="4"></td>
        <td id="LC4" class="blob-line-code js-file-line"><span class="cm">  * Copyright 2012 Goodybag, Inc.</span></td>
      </tr>
      <tr>
        <td id="L5" class="blob-line-num js-line-number" data-line-number="5"></td>
        <td id="LC5" class="blob-line-code js-file-line"><span class="cm"> * --</span></td>
      </tr>
      <tr>
        <td id="L6" class="blob-line-num js-line-number" data-line-number="6"></td>
        <td id="LC6" class="blob-line-code js-file-line"><span class="cm"> * Licensed under the Apache License, Version 2.0 (the &quot;License&quot;);</span></td>
      </tr>
      <tr>
        <td id="L7" class="blob-line-num js-line-number" data-line-number="7"></td>
        <td id="LC7" class="blob-line-code js-file-line"><span class="cm"> * you may not use this file except in compliance with the License.</span></td>
      </tr>
      <tr>
        <td id="L8" class="blob-line-num js-line-number" data-line-number="8"></td>
        <td id="LC8" class="blob-line-code js-file-line"><span class="cm"> * You may obtain a copy of the License at</span></td>
      </tr>
      <tr>
        <td id="L9" class="blob-line-num js-line-number" data-line-number="9"></td>
        <td id="LC9" class="blob-line-code js-file-line"><span class="cm"> *</span></td>
      </tr>
      <tr>
        <td id="L10" class="blob-line-num js-line-number" data-line-number="10"></td>
        <td id="LC10" class="blob-line-code js-file-line"><span class="cm"> * http://www.apache.org/licenses/LICENSE-2.0</span></td>
      </tr>
      <tr>
        <td id="L11" class="blob-line-num js-line-number" data-line-number="11"></td>
        <td id="LC11" class="blob-line-code js-file-line"><span class="cm"> *</span></td>
      </tr>
      <tr>
        <td id="L12" class="blob-line-num js-line-number" data-line-number="12"></td>
        <td id="LC12" class="blob-line-code js-file-line"><span class="cm"> * Unless required by applicable law or agreed to in writing, software</span></td>
      </tr>
      <tr>
        <td id="L13" class="blob-line-num js-line-number" data-line-number="13"></td>
        <td id="LC13" class="blob-line-code js-file-line"><span class="cm"> * distributed under the License is distributed on an &quot;AS IS&quot; BASIS,</span></td>
      </tr>
      <tr>
        <td id="L14" class="blob-line-num js-line-number" data-line-number="14"></td>
        <td id="LC14" class="blob-line-code js-file-line"><span class="cm"> * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.</span></td>
      </tr>
      <tr>
        <td id="L15" class="blob-line-num js-line-number" data-line-number="15"></td>
        <td id="LC15" class="blob-line-code js-file-line"><span class="cm"> * See the License for the specific language governing permissions and</span></td>
      </tr>
      <tr>
        <td id="L16" class="blob-line-num js-line-number" data-line-number="16"></td>
        <td id="LC16" class="blob-line-code js-file-line"><span class="cm"> * limitations under the License.</span></td>
      </tr>
      <tr>
        <td id="L17" class="blob-line-num js-line-number" data-line-number="17"></td>
        <td id="LC17" class="blob-line-code js-file-line"><span class="cm"> */</span></td>
      </tr>
      <tr>
        <td id="L18" class="blob-line-num js-line-number" data-line-number="18"></td>
        <td id="LC18" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L19" class="blob-line-num js-line-number" data-line-number="19"></td>
        <td id="LC19" class="blob-line-code js-file-line"><span class="p">(</span><span class="kd">function</span> <span class="p">(</span><span class="nx">$</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L20" class="blob-line-num js-line-number" data-line-number="20"></td>
        <td id="LC20" class="blob-line-code js-file-line">  <span class="kd">var</span> <span class="nx">Notification</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">element</span><span class="p">,</span> <span class="nx">options</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L21" class="blob-line-num js-line-number" data-line-number="21"></td>
        <td id="LC21" class="blob-line-code js-file-line">    <span class="c1">// Element collection</span></td>
      </tr>
      <tr>
        <td id="L22" class="blob-line-num js-line-number" data-line-number="22"></td>
        <td id="LC22" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">$element</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="nx">element</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L23" class="blob-line-num js-line-number" data-line-number="23"></td>
        <td id="LC23" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">$note</span>    <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="s1">&#39;&lt;div class=&quot;alert&quot;&gt;&lt;/div&gt;&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L24" class="blob-line-num js-line-number" data-line-number="24"></td>
        <td id="LC24" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">options</span>  <span class="o">=</span> <span class="nx">$</span><span class="p">.</span><span class="nx">extend</span><span class="p">(</span><span class="kc">true</span><span class="p">,</span> <span class="p">{},</span> <span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">notify</span><span class="p">.</span><span class="nx">defaults</span><span class="p">,</span> <span class="nx">options</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L25" class="blob-line-num js-line-number" data-line-number="25"></td>
        <td id="LC25" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L26" class="blob-line-num js-line-number" data-line-number="26"></td>
        <td id="LC26" class="blob-line-code js-file-line">    <span class="c1">// Setup from options</span></td>
      </tr>
      <tr>
        <td id="L27" class="blob-line-num js-line-number" data-line-number="27"></td>
        <td id="LC27" class="blob-line-code js-file-line">    <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">transition</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L28" class="blob-line-num js-line-number" data-line-number="28"></td>
        <td id="LC28" class="blob-line-code js-file-line">      <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">transition</span> <span class="o">==</span> <span class="s1">&#39;fade&#39;</span><span class="p">)</span></td>
      </tr>
      <tr>
        <td id="L29" class="blob-line-num js-line-number" data-line-number="29"></td>
        <td id="LC29" class="blob-line-code js-file-line">        <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;in&#39;</span><span class="p">).</span><span class="nx">addClass</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">transition</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L30" class="blob-line-num js-line-number" data-line-number="30"></td>
        <td id="LC30" class="blob-line-code js-file-line">      <span class="k">else</span></td>
      </tr>
      <tr>
        <td id="L31" class="blob-line-num js-line-number" data-line-number="31"></td>
        <td id="LC31" class="blob-line-code js-file-line">        <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">addClass</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">transition</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L32" class="blob-line-num js-line-number" data-line-number="32"></td>
        <td id="LC32" class="blob-line-code js-file-line">    <span class="p">}</span> <span class="k">else</span></td>
      </tr>
      <tr>
        <td id="L33" class="blob-line-num js-line-number" data-line-number="33"></td>
        <td id="LC33" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;fade&#39;</span><span class="p">).</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;in&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L34" class="blob-line-num js-line-number" data-line-number="34"></td>
        <td id="LC34" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L35" class="blob-line-num js-line-number" data-line-number="35"></td>
        <td id="LC35" class="blob-line-code js-file-line">    <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">type</span><span class="p">)</span></td>
      </tr>
      <tr>
        <td id="L36" class="blob-line-num js-line-number" data-line-number="36"></td>
        <td id="LC36" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;alert-&#39;</span> <span class="o">+</span> <span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">type</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L37" class="blob-line-num js-line-number" data-line-number="37"></td>
        <td id="LC37" class="blob-line-code js-file-line">    <span class="k">else</span></td>
      </tr>
      <tr>
        <td id="L38" class="blob-line-num js-line-number" data-line-number="38"></td>
        <td id="LC38" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;alert-success&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L39" class="blob-line-num js-line-number" data-line-number="39"></td>
        <td id="LC39" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L40" class="blob-line-num js-line-number" data-line-number="40"></td>
        <td id="LC40" class="blob-line-code js-file-line">    <span class="k">if</span><span class="p">(</span><span class="o">!</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span> <span class="o">&amp;&amp;</span> <span class="k">this</span><span class="p">.</span><span class="nx">$element</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s2">&quot;message&quot;</span><span class="p">)</span> <span class="o">!==</span> <span class="s1">&#39;&#39;</span><span class="p">)</span> <span class="c1">// dom text</span></td>
      </tr>
      <tr>
        <td id="L41" class="blob-line-num js-line-number" data-line-number="41"></td>
        <td id="LC41" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">html</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">$element</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s2">&quot;message&quot;</span><span class="p">));</span></td>
      </tr>
      <tr>
        <td id="L42" class="blob-line-num js-line-number" data-line-number="42"></td>
        <td id="LC42" class="blob-line-code js-file-line">    <span class="k">else</span></td>
      </tr>
      <tr>
        <td id="L43" class="blob-line-num js-line-number" data-line-number="43"></td>
        <td id="LC43" class="blob-line-code js-file-line">      <span class="k">if</span><span class="p">(</span><span class="k">typeof</span> <span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span> <span class="o">===</span> <span class="s1">&#39;object&#39;</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L44" class="blob-line-num js-line-number" data-line-number="44"></td>
        <td id="LC44" class="blob-line-code js-file-line">        <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span><span class="p">.</span><span class="nx">html</span><span class="p">)</span></td>
      </tr>
      <tr>
        <td id="L45" class="blob-line-num js-line-number" data-line-number="45"></td>
        <td id="LC45" class="blob-line-code js-file-line">          <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">html</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span><span class="p">.</span><span class="nx">html</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L46" class="blob-line-num js-line-number" data-line-number="46"></td>
        <td id="LC46" class="blob-line-code js-file-line">        <span class="k">else</span> <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span><span class="p">.</span><span class="nx">text</span><span class="p">)</span></td>
      </tr>
      <tr>
        <td id="L47" class="blob-line-num js-line-number" data-line-number="47"></td>
        <td id="LC47" class="blob-line-code js-file-line">          <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">text</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span><span class="p">.</span><span class="nx">text</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L48" class="blob-line-num js-line-number" data-line-number="48"></td>
        <td id="LC48" class="blob-line-code js-file-line">      <span class="p">}</span> <span class="k">else</span></td>
      </tr>
      <tr>
        <td id="L49" class="blob-line-num js-line-number" data-line-number="49"></td>
        <td id="LC49" class="blob-line-code js-file-line">        <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">html</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">message</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L50" class="blob-line-num js-line-number" data-line-number="50"></td>
        <td id="LC50" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L51" class="blob-line-num js-line-number" data-line-number="51"></td>
        <td id="LC51" class="blob-line-code js-file-line">    <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">closable</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L52" class="blob-line-num js-line-number" data-line-number="52"></td>
        <td id="LC52" class="blob-line-code js-file-line">      <span class="kd">var</span> <span class="nx">link</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="s1">&#39;&lt;a class=&quot;close pull-right&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt;&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L53" class="blob-line-num js-line-number" data-line-number="53"></td>
        <td id="LC53" class="blob-line-code js-file-line">      <span class="nx">$</span><span class="p">(</span><span class="nx">link</span><span class="p">).</span><span class="nx">on</span><span class="p">(</span><span class="s1">&#39;click&#39;</span><span class="p">,</span> <span class="nx">$</span><span class="p">.</span><span class="nx">proxy</span><span class="p">(</span><span class="nx">onClose</span><span class="p">,</span> <span class="k">this</span><span class="p">));</span></td>
      </tr>
      <tr>
        <td id="L54" class="blob-line-num js-line-number" data-line-number="54"></td>
        <td id="LC54" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">prepend</span><span class="p">(</span><span class="nx">link</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L55" class="blob-line-num js-line-number" data-line-number="55"></td>
        <td id="LC55" class="blob-line-code js-file-line">    <span class="p">}</span></td>
      </tr>
      <tr>
        <td id="L56" class="blob-line-num js-line-number" data-line-number="56"></td>
        <td id="LC56" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L57" class="blob-line-num js-line-number" data-line-number="57"></td>
        <td id="LC57" class="blob-line-code js-file-line">    <span class="k">return</span> <span class="k">this</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L58" class="blob-line-num js-line-number" data-line-number="58"></td>
        <td id="LC58" class="blob-line-code js-file-line">  <span class="p">};</span></td>
      </tr>
      <tr>
        <td id="L59" class="blob-line-num js-line-number" data-line-number="59"></td>
        <td id="LC59" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L60" class="blob-line-num js-line-number" data-line-number="60"></td>
        <td id="LC60" class="blob-line-code js-file-line">  <span class="kd">var</span> <span class="nx">onClose</span> <span class="o">=</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L61" class="blob-line-num js-line-number" data-line-number="61"></td>
        <td id="LC61" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">onClose</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L62" class="blob-line-num js-line-number" data-line-number="62"></td>
        <td id="LC62" class="blob-line-code js-file-line">    <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">).</span><span class="nx">remove</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L63" class="blob-line-num js-line-number" data-line-number="63"></td>
        <td id="LC63" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">onClosed</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L64" class="blob-line-num js-line-number" data-line-number="64"></td>
        <td id="LC64" class="blob-line-code js-file-line">    <span class="k">return</span> <span class="kc">false</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L65" class="blob-line-num js-line-number" data-line-number="65"></td>
        <td id="LC65" class="blob-line-code js-file-line">  <span class="p">};</span></td>
      </tr>
      <tr>
        <td id="L66" class="blob-line-num js-line-number" data-line-number="66"></td>
        <td id="LC66" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L67" class="blob-line-num js-line-number" data-line-number="67"></td>
        <td id="LC67" class="blob-line-code js-file-line">  <span class="nx">Notification</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">show</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L68" class="blob-line-num js-line-number" data-line-number="68"></td>
        <td id="LC68" class="blob-line-code js-file-line">    <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">fadeOut</span><span class="p">.</span><span class="nx">enabled</span><span class="p">)</span></td>
      </tr>
      <tr>
        <td id="L69" class="blob-line-num js-line-number" data-line-number="69"></td>
        <td id="LC69" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">delay</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">fadeOut</span><span class="p">.</span><span class="nx">delay</span> <span class="o">||</span> <span class="mi">3000</span><span class="p">).</span><span class="nx">fadeOut</span><span class="p">(</span><span class="s1">&#39;slow&#39;</span><span class="p">,</span> <span class="nx">$</span><span class="p">.</span><span class="nx">proxy</span><span class="p">(</span><span class="nx">onClose</span><span class="p">,</span> <span class="k">this</span><span class="p">));</span></td>
      </tr>
      <tr>
        <td id="L70" class="blob-line-num js-line-number" data-line-number="70"></td>
        <td id="LC70" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L71" class="blob-line-num js-line-number" data-line-number="71"></td>
        <td id="LC71" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">$element</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L72" class="blob-line-num js-line-number" data-line-number="72"></td>
        <td id="LC72" class="blob-line-code js-file-line">    <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">alert</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L73" class="blob-line-num js-line-number" data-line-number="73"></td>
        <td id="LC73" class="blob-line-code js-file-line">  <span class="p">};</span></td>
      </tr>
      <tr>
        <td id="L74" class="blob-line-num js-line-number" data-line-number="74"></td>
        <td id="LC74" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L75" class="blob-line-num js-line-number" data-line-number="75"></td>
        <td id="LC75" class="blob-line-code js-file-line">  <span class="nx">Notification</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">hide</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L76" class="blob-line-num js-line-number" data-line-number="76"></td>
        <td id="LC76" class="blob-line-code js-file-line">    <span class="k">if</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">fadeOut</span><span class="p">.</span><span class="nx">enabled</span><span class="p">)</span></td>
      </tr>
      <tr>
        <td id="L77" class="blob-line-num js-line-number" data-line-number="77"></td>
        <td id="LC77" class="blob-line-code js-file-line">      <span class="k">this</span><span class="p">.</span><span class="nx">$note</span><span class="p">.</span><span class="nx">delay</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">options</span><span class="p">.</span><span class="nx">fadeOut</span><span class="p">.</span><span class="nx">delay</span> <span class="o">||</span> <span class="mi">3000</span><span class="p">).</span><span class="nx">fadeOut</span><span class="p">(</span><span class="s1">&#39;slow&#39;</span><span class="p">,</span> <span class="nx">$</span><span class="p">.</span><span class="nx">proxy</span><span class="p">(</span><span class="nx">onClose</span><span class="p">,</span> <span class="k">this</span><span class="p">));</span></td>
      </tr>
      <tr>
        <td id="L78" class="blob-line-num js-line-number" data-line-number="78"></td>
        <td id="LC78" class="blob-line-code js-file-line">    <span class="k">else</span> <span class="nx">onClose</span><span class="p">.</span><span class="nx">call</span><span class="p">(</span><span class="k">this</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L79" class="blob-line-num js-line-number" data-line-number="79"></td>
        <td id="LC79" class="blob-line-code js-file-line">  <span class="p">};</span></td>
      </tr>
      <tr>
        <td id="L80" class="blob-line-num js-line-number" data-line-number="80"></td>
        <td id="LC80" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L81" class="blob-line-num js-line-number" data-line-number="81"></td>
        <td id="LC81" class="blob-line-code js-file-line">  <span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">notify</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">options</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L82" class="blob-line-num js-line-number" data-line-number="82"></td>
        <td id="LC82" class="blob-line-code js-file-line">    <span class="k">return</span> <span class="k">new</span> <span class="nx">Notification</span><span class="p">(</span><span class="k">this</span><span class="p">,</span> <span class="nx">options</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L83" class="blob-line-num js-line-number" data-line-number="83"></td>
        <td id="LC83" class="blob-line-code js-file-line">  <span class="p">};</span></td>
      </tr>
      <tr>
        <td id="L84" class="blob-line-num js-line-number" data-line-number="84"></td>
        <td id="LC84" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L85" class="blob-line-num js-line-number" data-line-number="85"></td>
        <td id="LC85" class="blob-line-code js-file-line">  <span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">notify</span><span class="p">.</span><span class="nx">defaults</span> <span class="o">=</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L86" class="blob-line-num js-line-number" data-line-number="86"></td>
        <td id="LC86" class="blob-line-code js-file-line">    <span class="nx">type</span><span class="o">:</span> <span class="s1">&#39;success&#39;</span><span class="p">,</span></td>
      </tr>
      <tr>
        <td id="L87" class="blob-line-num js-line-number" data-line-number="87"></td>
        <td id="LC87" class="blob-line-code js-file-line">    <span class="nx">closable</span><span class="o">:</span> <span class="kc">true</span><span class="p">,</span></td>
      </tr>
      <tr>
        <td id="L88" class="blob-line-num js-line-number" data-line-number="88"></td>
        <td id="LC88" class="blob-line-code js-file-line">    <span class="nx">transition</span><span class="o">:</span> <span class="s1">&#39;fade&#39;</span><span class="p">,</span></td>
      </tr>
      <tr>
        <td id="L89" class="blob-line-num js-line-number" data-line-number="89"></td>
        <td id="LC89" class="blob-line-code js-file-line">    <span class="nx">fadeOut</span><span class="o">:</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L90" class="blob-line-num js-line-number" data-line-number="90"></td>
        <td id="LC90" class="blob-line-code js-file-line">      <span class="nx">enabled</span><span class="o">:</span> <span class="kc">true</span><span class="p">,</span></td>
      </tr>
      <tr>
        <td id="L91" class="blob-line-num js-line-number" data-line-number="91"></td>
        <td id="LC91" class="blob-line-code js-file-line">      <span class="nx">delay</span><span class="o">:</span> <span class="mi">3000</span></td>
      </tr>
      <tr>
        <td id="L92" class="blob-line-num js-line-number" data-line-number="92"></td>
        <td id="LC92" class="blob-line-code js-file-line">    <span class="p">},</span></td>
      </tr>
      <tr>
        <td id="L93" class="blob-line-num js-line-number" data-line-number="93"></td>
        <td id="LC93" class="blob-line-code js-file-line">    <span class="nx">message</span><span class="o">:</span> <span class="kc">null</span><span class="p">,</span></td>
      </tr>
      <tr>
        <td id="L94" class="blob-line-num js-line-number" data-line-number="94"></td>
        <td id="LC94" class="blob-line-code js-file-line">    <span class="nx">onClose</span><span class="o">:</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{},</span></td>
      </tr>
      <tr>
        <td id="L95" class="blob-line-num js-line-number" data-line-number="95"></td>
        <td id="LC95" class="blob-line-code js-file-line">    <span class="nx">onClosed</span><span class="o">:</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{}</span></td>
      </tr>
      <tr>
        <td id="L96" class="blob-line-num js-line-number" data-line-number="96"></td>
        <td id="LC96" class="blob-line-code js-file-line">  <span class="p">}</span></td>
      </tr>
      <tr>
        <td id="L97" class="blob-line-num js-line-number" data-line-number="97"></td>
        <td id="LC97" class="blob-line-code js-file-line"><span class="p">})(</span><span class="nb">window</span><span class="p">.</span><span class="nx">jQuery</span><span class="p">);</span></td>
      </tr>
</table>

  </div>

  </div>
</div>

<a href="#jump-to-line" rel="facebox[.linejump]" data-hotkey="l" style="display:none">Jump to Line</a>
<div id="jump-to-line" style="display:none">
  <form accept-charset="UTF-8" class="js-jump-to-line-form">
    <input class="linejump-input js-jump-to-line-field" type="text" placeholder="Jump to line&hellip;" autofocus>
    <button type="submit" class="button">Go</button>
  </form>
</div>

        </div>

      </div><!-- /.repo-container -->
      <div class="modal-backdrop"></div>
    </div><!-- /.container -->
  </div><!-- /.site -->


    </div><!-- /.wrapper -->

      <div class="container">
  <div class="site-footer">
    <ul class="site-footer-links right">
      <li><a href="https://status.github.com/">Status</a></li>
      <li><a href="http://developer.github.com">API</a></li>
      <li><a href="http://training.github.com">Training</a></li>
      <li><a href="http://shop.github.com">Shop</a></li>
      <li><a href="/blog">Blog</a></li>
      <li><a href="/about">About</a></li>

    </ul>

    <a href="/" aria-label="Homepage">
      <span class="mega-octicon octicon-mark-github" title="GitHub"></span>
    </a>

    <ul class="site-footer-links">
      <li>&copy; 2014 <span title="0.03746s from github-fe136-cp1-prd.iad.github.net">GitHub</span>, Inc.</li>
        <li><a href="/site/terms">Terms</a></li>
        <li><a href="/site/privacy">Privacy</a></li>
        <li><a href="/security">Security</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
  </div><!-- /.site-footer -->
</div><!-- /.container -->


    <div class="fullscreen-overlay js-fullscreen-overlay" id="fullscreen_overlay">
  <div class="fullscreen-container js-suggester-container">
    <div class="textarea-wrap">
      <textarea name="fullscreen-contents" id="fullscreen-contents" class="fullscreen-contents js-fullscreen-contents js-suggester-field" placeholder=""></textarea>
    </div>
  </div>
  <div class="fullscreen-sidebar">
    <a href="#" class="exit-fullscreen js-exit-fullscreen tooltipped tooltipped-w" aria-label="Exit Zen Mode">
      <span class="mega-octicon octicon-screen-normal"></span>
    </a>
    <a href="#" class="theme-switcher js-theme-switcher tooltipped tooltipped-w"
      aria-label="Switch themes">
      <span class="octicon octicon-color-mode"></span>
    </a>
  </div>
</div>



    <div id="ajax-error-message" class="flash flash-error">
      <span class="octicon octicon-alert"></span>
      <a href="#" class="octicon octicon-x close js-ajax-error-dismiss" aria-label="Dismiss error"></a>
      Something went wrong with that request. Please try again.
    </div>


      <script crossorigin="anonymous" src="https://assets-cdn.github.com/assets/frameworks-12d5fda141e78e513749dddbc56445fe172cbd9a.js" type="text/javascript"></script>
      <script async="async" crossorigin="anonymous" src="https://assets-cdn.github.com/assets/github-f8cf379f177c2fd3562514979aef2b0ea1ccc9a2.js" type="text/javascript"></script>
      
      
        <script async src="https://www.google-analytics.com/analytics.js"></script>
  </body>
</html>

