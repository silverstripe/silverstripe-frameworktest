<style type="text/css">
	ul.stepIndicator {
		height:2.3em;
		margin-left: 0;
	}
		.stepIndicator li {
			display: block;
			float: left;
			margin-right: 20px;
			margin-left: 0px;
		}
			.stepIndicator li.current {
				font-weight: bold;
			}
</style>

<div class="typography">
	<% if Menu(2) %>
		<% include SideBar %>
		<div id="Content">
	<% end_if %>
			
	<% if Level(2) %>
	  	<% include BreadCrumbs %>
	<% end_if %>
	
		<h2>$Title</h2>
	
		<% if Content %>
		   <div class="typography">
		      $Content
		   </div>
		<% end_if %>
		<% if Page2MultiForm %>
			<% control Page2MultiForm %><% include MultiFormProgressList %><% end_control %>
			$Page2MultiForm
		<% end_if %>
		<% if Form %>
		   $Form
		<% end_if %>
		
		$PageComments
		
		
		$ContactForm
	<% if Menu(2) %>
		</div>
	<% end_if %>
</div>