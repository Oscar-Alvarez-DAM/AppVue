<template>
  <div class="students-container">
    <h2 class="text-2xl font-bold mb-6">Estudiantes</h2>

    <!-- Formulario para agregar estudiante -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h3 class="text-lg font-semibold mb-4">{{ editingStudent ? 'Editar Estudiante' : 'Nuevo Estudiante' }}</h3>
      <form @submit.prevent="saveStudent" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Nombre</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border rounded-md px-3 py-2"
            placeholder="Nombre del estudiante"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border rounded-md px-3 py-2"
            placeholder="email@example.com"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Curso</label>
          <select
            v-model="form.course_id"
            class="w-full border rounded-md px-3 py-2"
            required
          >
            <option value="">Selecciona un curso</option>
            <option v-for="course in courses" :key="course.id" :value="course.id">
              {{ course.name }}
            </option>
          </select>
        </div>
        <div class="flex gap-2">
          <button
            type="submit"
            class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-md"
          >
            {{ editingStudent ? 'Actualizar' : 'Crear' }}
          </button>
          <button
            v-if="editingStudent"
            type="button"
            @click="cancelEdit"
            class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>

    <!-- Lista de estudiantes -->
    <div class="space-y-4">
      <div v-if="students.length === 0" class="text-center text-gray-500 py-8">
        No hay estudiantes registrados
      </div>
      <div
        v-for="student in students"
        :key="student.id"
        class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500"
      >
        <div class="flex justify-between items-start mb-2">
          <div class="flex-1">
            <h4 class="text-lg font-semibold">{{ student.name }}</h4>
            <p class="text-gray-600">Email: {{ student.email }}</p>
            <p class="text-sm text-gray-500 mt-2">
              <strong>Curso:</strong> {{ student.course?.name || 'Sin asignar' }}
            </p>
          </div>
          <div class="flex gap-2">
            <button
              @click="editStudent(student)"
              class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded-md text-sm"
            >
              Editar
            </button>
            <button
              @click="deleteStudent(student.id)"
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

const students = ref([])
const courses = ref([])
const form = ref({
  name: '',
  email: '',
  course_id: ''
})
const editingStudent = ref(null)

const fetchStudents = async () => {
  try {
    const response = await axios.get('students')
    students.value = response.data
  } catch (error) {
    console.error('Error fetching students:', error)
    alert('Error al cargar los estudiantes')
  }
}

const fetchCourses = async () => {
  try {
    const response = await axios.get('courses')
    courses.value = response.data
  } catch (error) {
    console.error('Error fetching courses:', error)
  }
}

const saveStudent = async () => {
  try {
    if (editingStudent.value) {
      await axios.put(`students/${editingStudent.value.id}`, {
        name: form.value.name,
        email: form.value.email,
        course_id: parseInt(form.value.course_id)
      })
      alert('Estudiante actualizado correctamente')
    } else {
      await axios.post('students', {
        name: form.value.name,
        email: form.value.email,
        course_id: parseInt(form.value.course_id)
      })
      alert('Estudiante creado correctamente')
    }
    resetForm()
    await fetchStudents()
  } catch (error) {
    console.error('Error saving student:', error)
    alert('Error al guardar el estudiante: ' + (error.response?.data?.message || error.message))
  }
}

const editStudent = (student) => {
  editingStudent.value = student
  form.value = {
    name: student.name,
    email: student.email,
    course_id: student.course_id
  }
}

const cancelEdit = () => {
  resetForm()
}

const resetForm = () => {
  form.value = { name: '', email: '', course_id: '' }
  editingStudent.value = null
}

const deleteStudent = async (studentId) => {
  if (confirm('¿Deseas eliminar este estudiante?')) {
    try {
      await axios.delete(`students/${studentId}`)
      alert('Estudiante eliminado correctamente')
      await fetchStudents()
    } catch (error) {
      console.error('Error deleting student:', error)
      alert('Error al eliminar el estudiante')
    }
  }
}

onMounted(() => {
  fetchCourses()
  fetchStudents()
})
</script>

<style scoped>
.students-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
</style>
