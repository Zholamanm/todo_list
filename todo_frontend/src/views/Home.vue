<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-select
            v-model="selectedPriority"
            :items="priorities"
            label="Filter by Priority"
            clearable
        ></v-select>
      </v-col>
    </v-row>
    <TaskBoard
        :tasks="filteredTasks"
        @open-dialog="openTaskDialog"
        @view-task-details="openDetailDialog"
        @save-task="saveTask"
        @update-task-order="updateTaskOrder"
    />
    <TaskDialog
        v-model:visible="dialogVisible"
        :task="currentTask"
        @close="closeDialog"
        @save="saveTask"
    />
    <TaskDetailDialog
        v-model:visible="detailVisible"
        :task="currentTask"
        @close="closeDetailDialog"
        @delete="deleteTask"
    />
  </v-container>
</template>

<script>
import TaskBoard from '../components/TaskBoard.vue';
import TaskDialog from '../components/TaskDialog.vue';
import TaskDetailDialog from '../components/TaskDetailDialog.vue';
import axios from 'axios';

export default {
  components: { TaskBoard, TaskDialog, TaskDetailDialog },
  data() {
    return {
      tasks: [],
      dialogVisible: false,
      detailVisible: false,
      currentTask: null,
      selectedPriority: null,
      priorities: ['low', 'medium', 'high'],
    };
  },
  computed: {
    filteredTasks() {
      if (!this.selectedPriority) {
        return this.tasks;
      }
      return this.tasks.filter(task => task.priority === this.selectedPriority);
    },
  },
  async created() {
    await this.firstLogin();
    await this.fetchTasks();
  },
  methods: {
    async firstLogin() {
      try {
        const response = await axios.get('http://localhost:8000/api/first-login');
        const { token, user } = response.data;

        localStorage.setItem('auth_token', token);

        console.log('User:', user);
      } catch (error) {
        console.error('Error during first login:', error);
      }
    },
    async fetchTasks() {
      try {
        const response = await axios.get('http://localhost:8000/api/tasks', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
        });
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    openTaskDialog(task = null, status = 'To Do') {
      this.currentTask = task || { title: '', description: '', status: status, priority: 'low' };
      this.dialogVisible = true;
    },
    closeDialog() {
      this.dialogVisible = false;
      this.currentTask = null;
    },
    openDetailDialog(task) {
      this.currentTask = task;
      this.detailVisible = true;
    },
    closeDetailDialog() {
      this.detailVisible = false;
      this.currentTask = null;
    },
    async saveTask(task) {
      if (task.id) {
        await this.updateTask(task);
      } else {
        await this.addTask(task);
      }
      this.closeDialog();
      await this.fetchTasks();
    },
    async addTask(task) {
      try {
        const response = await axios.post('http://localhost:8000/api/tasks', task, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
        });
        this.tasks.push(response.data);
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    async updateTask(task) {
      try {
        await axios.put(`http://localhost:8000/api/tasks/${task.id}`, task, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
        });
      } catch (error) {
        console.error('Error updating task:', error);
      }
    },
    async deleteTask(taskId) {
      try {
        await axios.delete(`http://localhost:8000/api/tasks/${taskId}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
        });
        this.tasks = this.tasks.filter(task => task.id !== taskId);
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    },
    async updateTaskOrder(moved) {
      if (moved) {
        const task = moved.item._underlying_vm_;
        task.status = moved.to.parentNode.dataset.status;
        await this.updateTask(task);
      }
    },
  },
};
</script>
