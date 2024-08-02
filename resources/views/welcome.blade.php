<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Carrito de compras</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Styles -->
  @vite('resources/css/app.css')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="">
  <header class="fixed z-10">
    <div class="flex flex-wrap place-items-center">
      <!-- navbar -->
      <nav class="flex justify-between bg-gray-900 text-white w-screen">
        <div class="px-5 xl:px-12 py-4 flex w-full items-center">
          <a class="text-3xl font-bold font-heading" href="#">
            Carrito
          </a>
          <button class="ml-auto mr-0 rounded border p-2" onclick="openModal('modelConfirm')">
            <i class="bi bi-bag mr-2"></i>0
          </button>
        </div>
      </nav>
    </div>
  </header>
  <main class="container mx-auto pt-6 px-4">
    <!-- products list -->
    <section class="py-24">
      <div class="mx-auto">
        <h2 class="">Productos Disponibles</h2>

        <div class="products">
          <!-- SEKELETON PLACEHOLDER -->
          @for ($i = 0; $i < 3; $i++)
            <div class="max-w-md w-full mx-auto">
              <div class="max-w-md rounded overflow-hidden shadow-lg animate-pulse">
                <div class="h-48 bg-gray-300"></div>
                <div class="px-6 pt-4">
                  <div class="h-6 bg-gray-300 mb-2"></div>
                  <div class="h-4 bg-gray-300 w-1/3"></div>
                </div>
                <div class="px-6 pt-4 pb-2">
                  <div class="h-4 bg-gray-300 w-1/4 mb-2"></div>
                  <div class="h-8 bg-gray-300 w-3/3 mx-auto"></div>
                </div>
              </div>
            </div>
          @endfor
      </div>
      </div>
    </section>
  </main>

  <footer class="py-16 text-center">
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
  </footer>
  <!-- MODAL -->
  <x-modal />

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const updateCartQuantity = () => {
      $.get("/cart")
        .done(({
          data
        }) => {
          if (data !== undefined) {
            data = Object.values(data)
            let totalItems = 0

            data.forEach(({
              id,
              name,
              price,
              quantity
            }) => totalItems += quantity)

            document.querySelector('nav button').innerHTML = `<i class="bi bi-bag mr-1"></i> ${totalItems}`
          }
        })
    }
    updateCartQuantity()

    // GET PRODUCTS AND DISPLAY IT ON THE BODY
    $.get("/products", function() {})
      .done(function({
        products
      }) {
        const productsElement = document.querySelector('.products')

        productsElement.innerHTML = ''

        products.forEach(({
          id,
          name,
          price,
          image
        }) => {
          productsElement.innerHTML += `
            <div class="mx-auto products__item">
              <div class="products__item__img">
                <img src="{{ asset('./images/${image}.png') }}" alt="white shoes" class="responsive-img">
              </div>
              <div class="mt-5 products__item__info">
                <form action="" class="product-form">
                  <input type="text" name="id" value="${id}" hidden>
                  <input type="text" name="image" value="${image}" hidden>
                  <input type="text" name="quantity" value="1" hidden>
                  <div class="flex flex-col mb-2">
                    <label class="font-medium">${name}</label>
                    <input type="text" name="name" value="${name}" hidden>
                  </div>
                  <div class="flex flex-col">
                  <label class="">$${price}</label>
                  <input type="number" name="price" value="${price}" hidden>
                  </div>
                  <div class="flex mt-1">
                    <label for="quantity" class="mr-4">Cantidad</label>
                    <select name="quantity" id="quantity" class="px-2">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                  <button class="w-full mt-5 product-btn">
                    Agregar
                  </button>
                </form>
              </div>
            </div>`
        });
        // ADD PRODUCT TO CART
        $('.product-form').on('submit', function(e) {
          e.preventDefault()
          const formData = new FormData(this);
          const id = formData.get("id")
          const name = formData.get("name")
          const price = formData.get("price")
          const image = formData.get("image")
          const quantity = this.elements.quantity[1].value

          $.post('cart', {
              id: id,
              name: name,
              price: price,
              quantity: quantity,
              image: image
            })
            .done(function(data) {
              if (data.status === false) {
                Toastify({
                  text: data.message,
                  className: "toast-is-error",
                  offset: {
                    y: 40
                  }
                }).showToast();
              } else {
                Toastify({
                  text: data.message,
                  className: "toast-is-success",
                  offset: {
                    y: 80
                  }
                }).showToast();

                updateCartQuantity()
              }
            })
            .fail(function(error) {
              console.log(error);
            })
        });
      })
      .fail(function(e) {
        console.log(e);
      })

    const updateCartContent = () => {
      return $.get("/cart")
        .done(function({
          data
        }) {
          const modalContent = document.querySelector('.modal-content')

          if (data != undefined) {
            if (Object.prototype.toString.call(data) === '[object Object]' || data.length > 0) {
              data = Object.values(data)
              // FIRST ADD AN EMPTY CART
              modalContent.innerHTML = `
              <div class="container cart">
              <h1>Carrito de compras</h1>
              <div class="cart__container">
                <div class="cart-items"></div>
                <div class="cart-summary">
                  <h3>Resumen</h3>
                  <div class="cart-summary__totals">
                    <p>Subtotal</p>
                    <p class="total-value">$0</p>
                  </div>
                  <hr class="my-4" />
                  <div class="cart-summary__totals">
                    <p>Total</p>
                    <div>
                      <p class="total-value">$0</p>
                    </div>
                  </div>
                  <button class="product-btn mt-6">Comprar</button>
                </div>
              </div>
            </div>`

              const cartItemsContainer = document.querySelector('#modelConfirm .cart-items')
              const totalsElements = document.querySelectorAll('#modelConfirm .total-value')
              let total = 0

              cartItemsContainer.innerHTML = ''

              // THEN ADD ITEMS TO CART
              data.forEach(({
                id,
                name,
                price,
                quantity,
                image
              }) => {
                total += price * quantity

                cartItemsContainer.innerHTML += `
                <div class="cart-item">
                  <img src="{{ asset('./images/${image}.png') }}" alt="product-image" class="responsive-img" />
                  <div class="cart-item__info">
                    <h2>${name}</h2>
                    <p class="mt-1">$${quantity * price}</p>
                    <div class="cart-item__quantity flex mt-1">
                      <p class="mr-4">Cantidad: ${quantity}</p>
                    </div>
                    <div class="mt-5">
                      <form class="form-remove-item">
                        <input type="text" name="id" value="${id}" hidden>
                        <button><i class="bi bi-trash"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              `

                totalsElements.forEach(totalEl => {
                  totalEl.textContent = `$${total}`;
                })
              })

              // REMOVE ITEM FROM CART
              $('.form-remove-item').on('submit', function(e) {
                e.preventDefault()

                Swal.fire({
                  title: "Está seguro?",
                  text: "Esta acción eliminará el producto del carrito",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Eliminar",
                  cancelButtonText: "Cancelar"
                }).then((result) => {
                  if (result.isConfirmed) {

                    const formData = new FormData(this);
                    const id = formData.get("id")
                    $.ajax({
                        method: "DELETE",
                        url: `cart/${id}`,
                      })
                      .done(function(data) {
                        closeModal('modelConfirm')
                        Toastify({
                          text: data.message,
                          className: "toast-is-success",
                          offset: {
                            y: 80
                          }
                        }).showToast();

                        updateCartQuantity()
                      })
                      .fail(function() {
                        console.log("error");
                      })
                  }
                });
              });
            } else {
              modalContent.innerHTML = `
                <img src="{{ asset('./images/empty-box.png') }}" alt="white shoes" class="responsive-img">
                <p class="mx-auto w-fit text-2xl">Tu carrito está vacío</p>
              `
            }
          }
        })
    }

    const openModal = (modalId) => {
      document.getElementById(modalId).style.display = 'block'
      document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')

      updateCartContent()
    }

    const closeModal = (modalId) => {
      document.getElementById(modalId).style.display = 'none'
      document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
    }
  </script>
</body>
