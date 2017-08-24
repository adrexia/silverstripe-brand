<% with $Brand %>
    <% cached 'favicons', $LastEdited %>
        <% if $FaviconICO && $FaviconICO.exists() %>
            <link rel="shortcut icon" href="$FaviconICO.AbsoluteURL" />
        <% end_if %>
        <% if $FaviconPNG && $FaviconPNG.exists() %>
            <link rel="apple-touch-icon" sizes="57x57" href="$FaviconPNG.FitMax(57,57).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="60x60" href="$FaviconPNG.FitMax(60,60).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="72x72" href="$FaviconPNG.FitMax(72,72).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="76x76" href="$FaviconPNG.FitMax(76,76).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="114x114" href="$FaviconPNG.FitMax(114,114).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="120x120" href="$FaviconPNG.FitMax(120,120).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="144x144" href="$FaviconPNG.FitMax(144,144).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="152x152" href="$FaviconPNG.FitMax(152,152).AbsoluteURL" />
            <link rel="apple-touch-icon" sizes="180x180" href="$FaviconPNG.FitMax(180,180).AbsoluteURL" />
            <link rel="icon" type="image/png" sizes="192x192" href="$FaviconPNG.FitMax(192,192).AbsoluteURL" />
            <link rel="icon" type="image/png" sizes="32x32" href="$FaviconPNG.FitMax(32,32).AbsoluteURL" />
            <link rel="icon" type="image/png" sizes="96x96" href="$FaviconPNG.FitMax(96,96).AbsoluteURL" />
            <link rel="icon" type="image/png" sizes="16x16" href="$FaviconPNG.FitMax(16,16).AbsoluteURL" />
            <meta name="msapplication-TileColor" content="$getHex($FaviconTileColor)" />
            <meta name="msapplication-TileImage" content="$FaviconPNG.FitMax(144, 144).AbsoluteURL" />
            <meta name="theme-color" content="$getHex($FaviconTileColor)" />
        <% end_if %>
    <% end_cached %>
<% end_with %>