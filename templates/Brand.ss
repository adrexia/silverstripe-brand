<% if $Brand.Favicon %>
	<link rel="shortcut icon" href="$Brand.Favicon.AbsoluteURL" />
<% end_if %>

<style>
	<% if $Brand.FontImportURLS %>
		$Brand.FontImportURLS
	<% end_if %>
	body, p, ul {
		<% if $Brand.BodyFont %>
			font-family: "$Brand.BodyFont";
		<% end_if %>
		<% if $Brand.BodyFontColour %>
			color: $Brand.BodyFontColour;
		<% end_if %>
	}

	<% if $Brand.HeadingFont %>
		h1,h2,h3,h4,h5,h6 {
			font-family: "$Brand.HeadingFont";
		}
	<% end_if %>

</style>
