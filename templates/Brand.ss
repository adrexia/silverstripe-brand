<% if $Brand.Favicon %>
	<link rel="shortcut icon" href="$Brand.Favicon.AbsoluteURL" />
<% end_if %>

<style>
	$Brand.FontImportURLS

	body, p, ul {
		font-family: "$Brand.BodyFont";
		color: $Brand.BodyFontColour;
	}

	h1,h2,h3,h4,h5,h6 {
		font-family: "$Brand.HeadingFont";
	}

</style>
