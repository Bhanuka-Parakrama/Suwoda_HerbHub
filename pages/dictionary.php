<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Herbal Dic - Suwoda HerbHub</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="../assets/styles.css" />
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1;
    }

    .card-hover:hover {
      transform: scale(1.03);
      transition: 0.3s ease;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <?php include '../includes/header.php'; ?>

  <main>
    <div class="container py-5 mt-5">
      <h2 class="text-center mb-5 section-title text-dark" style="font-size: 2rem;">Herbal Dictionary</h2>

      <!-- Letter Buttons -->
      <div id="letters-container" class="row g-2 mb-4 justify-content-center"></div>

      <!-- Herbal Entries -->
      <div id="entries-container" class="row row-cols-1 row-cols-md-3 g-4"></div>
    </div>
  </main>

  <?php include '../includes/footer.php'; ?>

  <script>
    const dictionary = {
      A: [
        {
          word: "Ashwagandha",
          meaning: "An adaptogenic herb used to reduce stress.",
          image: "https://via.placeholder.com/300x180?text=Ashwagandha"
        },
        {
          word: "Aloe Vera",
          meaning: "Succulent plant used for skin healing.",
          image: "https://via.placeholder.com/300x180?text=Aloe+Vera"
        },
      ],
      B: [
        {
          word: "Brahmi",
          meaning: "Herb known to enhance memory and concentration.",
          image: "https://via.placeholder.com/300x180?text=Brahmi"
        },
        {
          word: "Basil",
          meaning: "Aromatic herb used in cooking and medicine.",
          image: "https://via.placeholder.com/300x180?text=Basil"
        },
      ],
      C: [
        {
          word: "Chyawanprash",
          meaning: "Herbal jam used as a health tonic.",
          image: "https://via.placeholder.com/300x180?text=Chyawanprash"
        },
        {
          word: "Chamomile",
          meaning: "Flower used to calm nerves and aid sleep.",
          image: "https://via.placeholder.com/300x180?text=Chamomile"
        },
      ],
      // Add more herbs as needed
    };

    const lettersContainer = document.getElementById("letters-container");
    const entriesContainer = document.getElementById("entries-container");

    for (let i = 65; i <= 90; i++) {
      const letter = String.fromCharCode(i);
      const col = document.createElement("div");
      col.className = "col-auto";

      const btn = document.createElement("button");
      btn.textContent = letter;
      btn.className = "btn btn-success letter-btn";
      btn.addEventListener("click", () => showEntries(letter));

      col.appendChild(btn);
      lettersContainer.appendChild(col);
    }

    function showEntries(letter) {
      entriesContainer.innerHTML = "";

      if (!dictionary[letter] || dictionary[letter].length === 0) {
        entriesContainer.innerHTML = `
          <div class="col-12">
            <div class="alert alert-warning text-center">
              No entries found for "<strong>${letter}</strong>".
            </div>
          </div>`;
        return;
      }

      dictionary[letter].forEach(({ word, meaning, image }) => {
        const col = document.createElement("div");
        col.className = "col";

        col.innerHTML = `
          <div class="card h-100 shadow-sm card-hover">
            <img src="${image}" class="card-img-top" alt="${word}" />
            <div class="card-body">
              <h5 class="card-title">${word}</h5>
              <p class="card-text">${meaning}</p>
            </div>
          </div>
        `;

        entriesContainer.appendChild(col);
      });
    }
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous">
  </script>

</body>
</html>
