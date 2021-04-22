<body>
  <!-- The embed's <iframe> will replace this <div> tag. -->
  <div id="myembed"></div>

  <script>
    var clientId = "demo";

    // This code loads the Gruveo Embed API code asynchronously.
    var tag = document.createElement("script");
    tag.src = "https://www.gruveo.com/embed-api/";
    var firstScriptTag = document.getElementsByTagName("script")[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // This function gets called after the API code downloads. It creates
    // the actual Gruveo embed and passes parameters to it.
    var embed;
    function onGruveoEmbedAPIReady() {
      embed = new Gruveo.Embed("myembed", {
        responsive: 1,
        embedParams: {
          clientid: clientId,
          code: "orange67"
        }
      });

      embed
        .on("error", onEmbedError)
        .on("requestToSignApiAuthToken", onEmbedRequestToSignApiAuthToken);
    }

    function onEmbedError(e) {
      console.error("Received error " + e.error + ".");
    }

    function onEmbedRequestToSignApiAuthToken(e) {
      // The below assumes that you have a server-side signer endpoint at /signer,
      // where you pass e.token in the body of a POST request.
      fetch('/signer', {
        method: 'POST',
        body: e.token
      })
        .then(function(res) {
          if (res.status !== 200) {  
            return;  
          }
          res.text()
            .then(function(signature) {
              embed.authorize(signature);
            });
        });
    }
  </script>
</body>
</html>