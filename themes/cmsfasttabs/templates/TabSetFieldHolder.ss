	<ul class="tabstrip">
	<% control Tabs %>
		<li class="$FirstLast $MiddleString"><a href="#$id" id="tab-$id" <% if FastTabName %>class="FastTab" data-name="$FastTabName" data-id="#$id"<% end_if %>>$Title</a></li>
	<% end_control %>
	</ul>
	
	<% control Tabs %>
		<div class="tab" id="$id">
		<% if Tabs %>
			$FieldHolder
		<% else %>
			<% control Fields %>
			$FieldHolder
			<% end_control %>
		<% end_if %>
		</div>
	<% end_control %>