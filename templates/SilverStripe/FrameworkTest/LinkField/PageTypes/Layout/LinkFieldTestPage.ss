<div class="content search-results">
    <div class="container">
        <div class="row">
            <section class="col-lg-8 offset-lg-2">
                <div class="search-results__heading">
                    <h1>$Title.XML</h1>

                    <% if $HasOneLink %>
                        <div class="mt-1">
                            <h4>Single Link</h4>
                            <% with $HasOneLink %>
                                <% if $exists %>
                                    <a href="$URL" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>$Title</a>
                                <% end_if %>
                            <% end_with %>
                        </div>
                    <% end_if %>


                    <% if $HasManyLinks %>
                    <div class="mt-1">
                        <h4>Multiple Link</h4>
                        <ul>
                            <% loop $HasManyLinks %>
                                <li>$Me</li>
                            <% end_loop %>
                        </ul>
                    </div>
                    <% end_if %>
                </div>
            </section>
        </div>
    </div>
</div>
