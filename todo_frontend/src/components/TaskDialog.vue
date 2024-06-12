<template>
  <v-dialog v-model="internalVisible" max-width="600px">
    <v-card>
      <v-card-title>
        <span class="text-h5">{{ task.title !== "" ? 'Edit Task' : 'New Task' }}</span>
      </v-card-title>
      <v-card-text>
        <v-form>
          <v-text-field v-model="localTask.title" label="Title" required></v-text-field>
          <v-text-field v-model="localTask.description" label="Description" required></v-text-field>
          <v-select
              v-model="localTask.status"
              :items="statuses"
              label="Status"
              required
          ></v-select>
          <v-select
              v-model="localTask.priority"
              :items="priorities"
              label="Priority"
              required
          ></v-select>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn color="blue darken-1" text @click="save">Save</v-btn>
        <v-btn color="grey" text @click="close">Cancel</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'TaskDialog',
  props: {
    task: Object,
    visible: Boolean,
  },
  data() {
    return {
      internalVisible: this.visible,
      localTask: this.task ? { ...this.task } : { title: '', description: '', status: '', priority: '' },
      statuses: ['To Do', 'In Progress', 'Done'],
      priorities: ['low', 'medium', 'high'],
    };
  },
  watch: {
    task: {
      handler(newValue) {
        this.localTask = newValue ? { ...newValue } : { title: '', description: '', status: '', priority: '' };
      },
      deep: true,
    },
    visible: {
      handler(newValue) {
        this.internalVisible = newValue;
      },
    },
  },
  methods: {
    save() {
      this.$emit('save', this.localTask);
      this.close();
    },
    close() {
      this.internalVisible = false;
      this.$emit('update:visible', false);
    },
  },
};
</script>
