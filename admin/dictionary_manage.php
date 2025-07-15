<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dictionary Management</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: Arial, sans-serif;
        background: #e6f9ec; /* light green */
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px #0002;
        padding: 32px 28px;
      }
      h2 {
        text-align: center;
        color: #333;
        margin-bottom: 28px;
      }
      .entry {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        background: #f9f9f9;
        margin-bottom: 12px;
        padding: 12px 16px;
        border-radius: 8px;
        gap: 16px;
        box-shadow: 0 1px 4px #0001;
      }
      .entry-img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #eee;
      }
      .word {
        font-weight: bold;
        color: #222;
        min-width: 90px;
        font-size: 1.1rem;
      }
      .meaning {
        color: #555;
        margin-left: 10px;
        flex: 1;
        font-size: 1rem;
      }
      .search-box {
        margin-bottom: 18px;
      }
    </style>
  </head>
  <body>
    <div class="container shadow-lg">
      <h2>Dictionary Management</h2>
      <div
        id="letters"
        class="mb-3 d-flex flex-wrap justify-content-center gap-2"
      ></div>
      <div id="letterFormContainer"></div>
      <form id="addForm" class="row g-3 mb-4 d-none" autocomplete="off">
        <div class="col-md-5">
          <input
            type="text"
            id="word"
            class="form-control"
            placeholder="Word"
            required
          />
        </div>
        <div class="col-md-7">
          <input
            type="text"
            id="desc"
            class="form-control"
            placeholder="Description"
            required
          />
        </div>
        <div class="col-md-7">
          <input type="file" id="image" accept="image/*" class="form-control" />
        </div>
        <div class="col-md-5 d-grid">
          <button type="submit" class="btn btn-success">Add / Update</button>
        </div>
      </form>
      <input
        class="form-control search-box"
        type="text"
        id="search"
        placeholder="Search word..."
      />
      <div class="dict-list" id="dictList"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // --- Letter Buttons and Letter State ---
      let selectedLetter = "";
      function renderLetters() {
        const lettersDiv = document.getElementById("letters");
        lettersDiv.innerHTML = "";
        for (let i = 65; i <= 90; i++) {
          const letter = String.fromCharCode(i);
          const btn = document.createElement("button");
          btn.textContent = letter;
          btn.type = "button";
          btn.className = "btn btn-outline-success";
          if (selectedLetter === letter) btn.classList.add("active");
          btn.onclick = function () {
            selectedLetter = letter;
            renderLetters();
            showLetterForm(letter);
            renderList();
          };
          lettersDiv.appendChild(btn);
        }
      }

      // --- Letter Form ---
      function showLetterForm(letter) {
        document.getElementById("addForm").classList.remove("d-none");
        const container = document.getElementById("letterFormContainer");
        container.innerHTML = <div class='mb-2 text-center'><span class='badge bg-success fs-5'>${letter}</span></div>;
      }

      // --- Store and Render per-letter info ---
      function getDictionary() {
        return JSON.parse(localStorage.getItem("dictionary") || "{}");
      }
      function setDictionary(dict) {
        localStorage.setItem("dictionary", JSON.stringify(dict));
      }
      function renderList() {
        const dict = getDictionary();
        const list = document.getElementById("dictList");
        list.innerHTML = "";
        if (!selectedLetter) {
          list.innerHTML =
            '<div class="text-center text-muted">Select a letter to add/view information.</div>';
          document.getElementById("addForm").classList.add("d-none");
          document.getElementById("letterFormContainer").innerHTML = "";
          return;
        }
        const data = dict[selectedLetter] || {};
        if (!data.img && !data.word && !data.desc) {
          list.innerHTML =
            '<div class="text-center text-muted">No information for this letter yet.</div>';
        } else {
          const entry = document.createElement("div");
          entry.className = "entry";
          entry.innerHTML =
            (data.img
              ? <img class='entry-img' src='${data.img}' alt='${selectedLetter}' />
              : "") +
            `<span class="word">${
              data.word || ""
            }</span><span class="meaning">${data.desc || ""}</span>`;
          list.appendChild(entry);
        }
      }

      // --- Form Submission ---
      document.getElementById("addForm").onsubmit = function (e) {
        e.preventDefault();
        if (!selectedLetter) return;
        const word = document.getElementById("word").value.trim();
        const desc = document.getElementById("desc").value.trim();
        const imageInput = document.getElementById("image");
        const dict = getDictionary();
        function saveAndRender(imgData) {
          dict[selectedLetter] = { img: imgData, word, desc };
          setDictionary(dict);
          renderList();
          document.getElementById("addForm").reset();
        }
        if (imageInput.files && imageInput.files[0]) {
          const reader = new FileReader();
          reader.onload = function (ev) {
            saveAndRender(ev.target.result);
          };
          reader.readAsDataURL(imageInput.files[0]);
        } else {
          let oldImg = "";
          if (
            dict[selectedLetter] &&
            typeof dict[selectedLetter] === "object"
          ) {
            oldImg = dict[selectedLetter].img || "";
            // Keep old word/desc if not filled
            if (!word && dict[selectedLetter].word)
              document.getElementById("word").value = dict[selectedLetter].word;
            if (!desc && dict[selectedLetter].desc)
              document.getElementById("desc").value = dict[selectedLetter].desc;
          }
          saveAndRender(oldImg);
        }
      };

      // --- Initial Render ---
      renderLetters();
      renderList();
    </script>
  </body>
</html>