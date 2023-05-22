document.getElementById('search-input').addEventListener('keyup', function() {
    searchUsers(this.value);
});
function searchUsers(query) {
    axios.get('/search', {
        params: {
            q: query
        }
    })
        .then(function (response) {
            // Handle the response and update the search results container
            var searchResults = document.getElementById('search-results');
            searchResults.innerHTML = '';

            for (var i = 0; i < response.data.length; i++) {
                var user = response.data[i];
                var userLink = '<a href="${user.name}">' + user.name + '</a>';
                var userItem = '<div>' + userLink + '</div>';
                searchResults.insertAdjacentHTML('beforeend', userItem);
            }
        })
        .catch(function (error) {
            console.error(error);
        });
}
