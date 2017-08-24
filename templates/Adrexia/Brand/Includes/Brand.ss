<% include Adrexia/Brand/Favicons %>

<% with $Brand %>
    <% cached 'brand', $LastEdited %>
        <style>
            <% if $FontImportURLS %>
                $FontImportURLS
            <% end_if %>

            <% if $BodyBackgroundColour %>
                html {
                    background-color: $getHex($BodyBackgroundColour);
                }
            <% end_if %>

            <% if $BodyFont || $BodyFontColour %>
                body, p, ul {
                    <% if $BodyFont %>
                        font-family: "$BodyFont";
                    <% end_if %>
                    <% if $BodyFontColour %>
                        color: $getHex($BodyFontColour);
                    <% end_if %>
                }
            <% end_if %>

            <% if $BaseFontSize %>
                body,
                html {
                    <% if $BaseFontSize %>
                        font-size: {$BaseFontSize}px;
                    <% end_if %>
                }
            <% end_if %>

            <% if $MainHeadingFontSize %>
                h1 {
                    font-size: {$MainHeadingFontSize}px;
                }
            <% end_if %>

            <% if $HeadingFont %>
                h1,h2,h3,h4,h5,h6 {
                    font-family: "$HeadingFont";
                }
            <% end_if %>

            <% if $BodyLinkColour %>
                a:visited,
                a {
                    color: $getHex($BodyLinkColour);
                }

            <% end_if %>

            <% if $BodyLinkHoverColour %>
                a:hover,
                a:focus {
                    color: $getHex($BodyLinkHoverColour);
                }
            <% end_if %>

        </style>
    <% end_cached %>
<% end_with %>
