  @props(['title' => 'Auth'])

  <div class="flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-10">
      <div class="relative flex flex-col items-start justify-center px-4 sm:px-6 lg:px-8">
          <div class="bg-base-200 shadow-base-300/20 z-1 w-full space-y-6 rounded-xl p-6 shadow-md sm:min-w-md lg:p-8">
              <div class="flex flex-wrap gap-3 items-center text-center">
                  <div class="text-base-content text-xl font-bold">Threadit</div>
                  |
                  <p class="text-base-content/80">Talk, tangle, repeat.</p>
              </div>
              <div>
                  <h2 class="text-base-content mb-1.5 text-3xl font-semibold">{{ $title }}</h2>
              </div>

              {{ $slot }}

          </div>
      </div>
  </div>
