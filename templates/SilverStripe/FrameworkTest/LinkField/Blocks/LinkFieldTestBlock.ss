<% if $OneLink %>
  <div class="mt-1">
    <h4>Single Link</h4>
    <% with $OneLink %>
        <% if $exists %>
            <a href="$URL" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>$Title</a>
        <% end_if %>
    <% end_with %>
  </div>
<% end_if %>

<% if $ManyLinks %>
  <div class="mt-1">
    <h4>Multiple Link</h4>
    <ul>
        <% loop $ManyLinks %>
            <li>$Me</li>
        <% end_loop %>
    </ul>
  </div>
<% end_if %>
