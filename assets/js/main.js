// FoodFusion Main JavaScript File
$(document).ready(function () {
  // Toggle between login and registration modals
  // Function to switch modals
  function switchModal(showId) {
    var showModal = $(`#${showId}`)

    $(".modal").modal("hide")

    $("body").removeClass("modal-open")
    $(".modal-backdrop").remove()

    showModal.modal("show")
  }

  // Login link → open login modal
  document.getElementById("loginLink")?.addEventListener("click", function (e) {
    e.preventDefault()
    switchModal("registerModal")
  })

  // Register link → open register modal
  document
    .getElementById("registerLink")
    ?.addEventListener("click", function (e) {
      e.preventDefault()
      switchModal("loginModal")
    })

  // Show join modal when join button is clicked
  $(".join-btn").on("click", function (e) {
    e.preventDefault()
    switchModal("registerModal", "loginModal")
  })

  // Handle login form submission
  $('form[action*="login.php"]').on("submit", function (e) {
    e.preventDefault()
    var formData = $(this).serialize()

    $.ajax({
      type: "POST",
      url: "/foodfusion/auth/login.php",
      data: formData,
      success: function (response) {
        window.location.href = "/foodfusion/index.php"
      },
    })
  })

  // Handle registration form submission
  $('form[action*="register.php"]').on("submit", function (e) {
    e.preventDefault()

    const password = $("#register-password").val()
    const confirmPassword = $("#confirm-password").val()

    if (password !== confirmPassword) {
      alert("Passwords do not match!")
      return false
    }

    var formData = $(this).serialize()

    $.ajax({
      type: "POST",
      url: "/foodfusion/auth/register.php",
      data: formData,
      success: function (response) {
        if (response.success) {
          alert("Registration successful! Please log in.")
          $("#registerModal").modal("hide")
          setTimeout(function () {
            $("#loginModal").modal("show")
          }, 500)
        } else {
          alert("Registration failed: " + response.message)
        }
      },
      error: function (xhr, status, error) {
        alert("Registration error: " + error)
        console.log(xhr.responseText)
      },
    })
  })

  // Cookie consent
  if (!localStorage.getItem("cookieConsent")) {
    $("#cookieConsentBanner").show()
  } else {
    $("#cookieConsentBanner").hide()
  }

  $(".accept-cookies").on("click", function () {
    localStorage.setItem("cookieConsent", "accepted")
    $("#cookieConsentBanner").hide()
  })

  $(".cookie-settings").on("click", function () {
    // Cookie settings functionality would go here
    $("#cookieConsentBanner").hide()
  })

  // Recipe filter functionality
  $(".recipe-filter").on("change", function () {
    filterRecipes()
  })

  function filterRecipes() {
    const cuisine = $("#cuisine-filter").val()
    const dietary = $("#dietary-filter").val()
    const difficulty = $("#difficulty-filter").val()

    $(".recipe-item").each(function () {
      const $recipe = $(this)
      const recipeCuisine = $recipe.data("cuisine")
      const recipeDietary = $recipe.data("dietary")
      const recipeDifficulty = $recipe.data("difficulty")

      const cuisineMatch = cuisine === "all" || recipeCuisine === cuisine
      const dietaryMatch = dietary === "all" || recipeDietary === dietary
      const difficultyMatch =
        difficulty === "all" || recipeDifficulty === difficulty

      if (cuisineMatch && dietaryMatch && difficultyMatch) {
        $recipe.show()
      } else {
        $recipe.hide()
      }
    })
  }

  // Recipe search functionality
  $("#recipe-search").on("input", function () {
    const searchTerm = $(this).val().toLowerCase()

    $(".recipe-item").each(function () {
      const $recipe = $(this)
      const recipeTitle = $recipe.find(".card-title").text().toLowerCase()
      const recipeDesc = $recipe.find(".card-text").text().toLowerCase()

      if (recipeTitle.includes(searchTerm) || recipeDesc.includes(searchTerm)) {
        $recipe.show()
      } else {
        $recipe.hide()
      }
    })
  })

  // Image preview for recipe submission
  $("#recipe-image").on("change", function () {
    const file = this.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = function (e) {
        $("#image-preview").attr("src", e.target.result).show()
      }
      reader.readAsDataURL(file)
    }
  })

  // Dynamic ingredient and instruction fields
  let ingredientCount = 1
  let instructionCount = 1

  $("#add-ingredient").on("click", function () {
    ingredientCount++
    const newIngredient = `
            <div class="ingredient-row">
                <div class="form-row">
                    <div class="col-md-5">
                        <input type="text" class="form-control mb-2" name="ingredient_name[]" placeholder="Ingredient name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control mb-2" name="ingredient_amount[]" placeholder="Amount" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control mb-2" name="ingredient_unit[]" placeholder="Unit">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-ingredient"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        `
    $("#ingredients-container").append(newIngredient)
  })

  $("#add-instruction").on("click", function () {
    instructionCount++
    const newInstruction = `
            <div class="instruction-row">
                <div class="form-row">
                    <div class="col-md-11">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Step ${instructionCount}</span>
                            </div>
                            <textarea class="form-control" name="instructions[]" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-instruction"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        `
    $("#instructions-container").append(newInstruction)
  })

  // Remove ingredient or instruction
  $(document).on("click", ".remove-ingredient", function () {
    $(this).closest(".ingredient-row").remove()
  })

  $(document).on("click", ".remove-instruction", function () {
    $(this).closest(".instruction-row").remove()
    // Renumber the steps
    $(".instruction-row").each(function (index) {
      $(this)
        .find(".input-group-text")
        .text("Step " + (index + 1))
    })
    instructionCount = $(".instruction-row").length
  })

  // Enhanced Rating system
  $(".rating-stars i").on("click", function () {
    const value = $(this).data("value")
    $("#rating-value").val(value)

    // Update stars
    $(".rating-stars i").each(function () {
      if ($(this).data("value") <= value) {
        $(this).removeClass("far").addClass("fas")
      } else {
        $(this).removeClass("fas").addClass("far")
      }
    })
  })

  // Star Rating Hover Effect
  $(".rating-stars i").on("mouseenter", function () {
    var rating = $(this).data("value")
    var stars = $(this).parent().find("i")

    stars.each(function (index) {
      if ($(this).data("value") <= rating) {
        $(this).removeClass("far").addClass("fas")
      } else {
        $(this).removeClass("fas").addClass("far")
      }
    })
  })

  // Reset stars on mouse leave if no rating selected
  $(".rating-stars").on("mouseleave", function () {
    var selectedRating = $("#rating-value").val()
    var stars = $(this).find("i")

    if (selectedRating > 0) {
      stars.each(function () {
        if ($(this).data("value") <= selectedRating) {
          $(this).removeClass("far").addClass("fas")
        } else {
          $(this).removeClass("fas").addClass("far")
        }
      })
    } else {
      stars.removeClass("fas").addClass("far")
    }
  })

  // Form validation for rating
  $('form[action*="rate_recipe.php"]').on("submit", function (e) {
    var rating = $("#rating-value").val()
    var comment = $("#comment").val().trim()
    var userName = $("#user_name").val().trim()

    if (rating == 0) {
      e.preventDefault()
      alert("Please select a rating before submitting.")
      return false
    }

    if (comment === "") {
      e.preventDefault()
      alert("Please write a comment before submitting.")
      return false
    }

    if (userName === "") {
      e.preventDefault()
      alert("Please enter your name before submitting.")
      return false
    }
  })
})
