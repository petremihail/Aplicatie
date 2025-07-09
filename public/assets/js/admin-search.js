document.addEventListener("DOMContentLoaded", () => {
    // Search functionality for tables
    const searchInputs = document.querySelectorAll(".search-input")
  
    searchInputs.forEach((input) => {
      input.addEventListener("keyup", function () {
        const searchTerm = this.value.toLowerCase()
        const table = this.closest(".card").querySelector(".searchable-table")
  
        if (table) {
          const rows = table.querySelectorAll("tbody tr")
  
          rows.forEach((row) => {
            const text = row.textContent.toLowerCase()
            if (text.includes(searchTerm)) {
              row.style.display = ""
            } else {
              row.style.display = "none"
            }
          })
        }
      })
    })
  })
  