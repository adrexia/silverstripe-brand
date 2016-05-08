<% with $Brand %>
	<% if $Favicon %>
		<link rel="shortcut icon" href="$Favicon.AbsoluteURL" />
	<% end_if %>

	<style>

		<% if $FontImportURLS %>
			$FontImportURLS
		<% end_if %>

		<% if $BodyBackgroundColour %>
			html {
				background-color: $getHex($BodyBackgroundColour);
			}
		<% end_if %>

		body, p, ul {
			<% if $BodyFont %>
				font-family: "$BodyFont";
			<% end_if %>
			<% if $BodyFontColour %>
				color: $getHex($BodyFontColour);
			<% end_if %>
		}

		body,
		html {
			<% if $BaseFontSize %>
				font-size: {$BaseFontSize}px;
			<% end_if %>
		}

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
		<% else %>
			a:hover,
			a:focus {
				opacity: 0.8;
			}
		<% end_if %>



	</style>

<% end_with %>
