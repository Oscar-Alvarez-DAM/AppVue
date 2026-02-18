<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-md">
      <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold">Gestión de Cursos y Estudiantes</h1>
      </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex gap-4">
          <button
            @click="currentTab = 'courses'"
            :class="[
              'px-4 py-3 font-medium border-b-2 transition-colors',
              currentTab === 'courses'
                ? 'border-blue-600 text-blue-600'
                : 'border-transparent text-gray-600 hover:text-blue-600'
            ]"
          >
            Cursos
          </button>
          <button
            @click="currentTab = 'students'"
            :class="[
              'px-4 py-3 font-medium border-b-2 transition-colors',
              currentTab === 'students'
                ? 'border-green-600 text-green-600'
                : 'border-transparent text-gray-600 hover:text-green-600'
            ]"
          >
            Estudiantes
          </button>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto flex-grow">
      <CoursesList v-if="currentTab === 'courses'" />
      <StudentsList v-if="currentTab === 'students'" />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4 mt-12">
      <p>&copy; 2026 Gestión de Cursos y Estudiantes - Aplicación Laravel + Vue</p>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import CoursesList from './CoursesList.vue'
import StudentsList from './StudentsList.vue'

const currentTab = ref('courses')
</script>

<style scoped>
:deep(body) {
  margin: 0;
  padding: 0;
}
</style>
