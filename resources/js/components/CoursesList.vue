<template>
  <div class="courses-container">
    <h2 class="text-2xl font-bold mb-6">Cursos</h2>

    <!-- Formulario para agregar curso -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h3 class="text-lg font-semibold mb-4">{{ editingCourse ? 'Editar Curso' : 'Nuevo Curso' }}</h3>
      <form @submit.prevent="saveCourse" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Nombre</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border rounded-md px-3 py-2"
            placeholder="Nombre del curso"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Descripción</label>
          <textarea
            v-model="form.description"
            class="w-full border rounded-md px-3 py-2"
            placeholder="Descripción del curso"
            rows="3"
          ></textarea>
        </div>
        <div class="flex gap-2">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
          >
            {{ editingCourse ? 'Actualizar' : 'Crear' }}
          </button>
          <button
            v-if="editingCourse"
            type="button"
            @click="cancelEdit"
            class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>

    <!-- Lista de cursos -->
    <div class="space-y-4">
      <div v-if="courses.length === 0" class="text-center text-gray-500 py-8">
        No hay cursos disponibles
      </div>
      <div
        v-for="course in courses"
        :key="course.id"
        class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500"
      >
        <div class="flex justify-between items-start mb-2">
          <div class="flex-1">
            <h4 class="text-lg font-semibold">{{ course.name }}</h4>
            <p class="text-gray-600 mt-1">{{ course.description || 'Sin descripción' }}</p>
            <p class="text-sm text-gray-500 mt-2">
              <strong>Estudiantes:</strong> {{ course.students?.length || 0 }}
            </p>
          </div>
          <div class="flex gap-2">
            <button
              @click="editCourse(course)"
              class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded-md text-sm"
            >
              Editar
            </button>
            <button
              @click="deleteCourse(course.id)"
              class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm"
            >
              Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const courses = ref([])
const form = ref({
  name: '',
  description: ''
})
const editingCourse = ref(null)

const fetchCourses = async () => {
  try {
    const response = await axios.get('/api/courses')
    courses.value = response.data
  } catch (error) {
    console.error('Error fetching courses:', error)
    alert('Error al cargar los cursos')
  }
}

const saveCourse = async () => {
  try {
    if (editingCourse.value) {
      await axios.put(`/api/courses/${editingCourse.value.id}`, form.value)
      alert('Curso actualizado correctamente')
    } else {
      await axios.post('/api/courses', form.value)
      alert('Curso creado correctamente')
    }
    resetForm()
    await fetchCourses()
  } catch (error) {
    console.error('Error saving course:', error)
    alert('Error al guardar el curso')
  }
}

const editCourse = (course) => {
  editingCourse.value = course
  form.value = {
    name: course.name,
    description: course.description || ''
  }
}

const cancelEdit = () => {
  resetForm()
}

const resetForm = () => {
  form.value = { name: '', description: '' }
  editingCourse.value = null
}

const deleteCourse = async (courseId) => {
  if (confirm('¿Deseas eliminar este curso?')) {
    try {
      await axios.delete(`/api/courses/${courseId}`)
      alert('Curso eliminado correctamente')
      await fetchCourses()
    } catch (error) {
      console.error('Error deleting course:', error)
      if (error.response?.status === 409) {
        alert(error.response.data.message)
      } else {
        alert('Error al eliminar el curso')
      }
    }
  }
}

onMounted(() => {
  fetchCourses()
})
</script>

<style scoped>
.courses-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
</style>
