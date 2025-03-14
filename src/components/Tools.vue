<template>
  <div class="p-6 max-w-4xl mx-auto bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tools <small class="text-sm text-gray-500">Tailwind CSS Ready</small></h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-gradient-to-r from-blue-500 to-teal-400 p-4 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold text-white">Tailwind Example</h3>
        <p class="text-white/80 mt-2">
          This card uses Tailwind's utility classes for styling.
        </p>
      </div>
      
      <div class="bg-gray-100 p-4 rounded-lg shadow hover:shadow-md transition duration-300">
        <h3 class="text-xl font-semibold text-gray-700">Interactive Elements</h3>
        <div class="mt-4 space-y-2">
          <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition duration-300">
            Primary Button
          </button>
          <button class="bg-transparent border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-medium py-2 px-4 rounded transition duration-300 ml-2">
            Secondary
          </button>
        </div>
      </div>
    </div>
    
    <div class="mt-6 p-4 bg-amber-100 rounded-lg">
      <p class="text-amber-800">
        Tailwind CSS is working! You can now use all Tailwind utility classes in your Vue components.
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminTools'
}
</script> 