<script>
  export default {
    props: [ 'the_doctor_id','the_schedule','the_day_id' ],

    data() {
      return {
        creating : false,
        editing  : false,
        // day_id   : this.the_day_id,
        // doctor_id: this.the_doctor_id,
        schedule : this.the_schedule,
        form: new Form({
          // id        : '',
          doctor_id : this.the_doctor_id,
          day_id    : this.the_day_id,
          start_at  : '',
          end_at    : '',
        })
      };
    },

    computed: {
      //
    },

    methods: {
      create() {
        this.creating = true;
      },
      store() {
        this.$Progress.start();
        this.form.post('/schedules')
        .then(() => {

          // Event.$emit('RefreshPage');
          toast({
              type: 'success',
              title: 'Schedule created successfully'
          });
          this.closeForm();
          this.$Progress.finish();
        })
        .catch(() => { this.$Progress.fail();});
      },
      
      edit(schedule) {
        this.editing = true;
        this.form.clear(); // VForm, clears error message
        this.form.reset(); // VForm
        this.form.fill(schedule);
      },
      update() {
        this.$Progress.start();
        this.form.patch('/schedules/' + this.schedule.id)
        .then(() => {

          // Event.$emit('RefreshPage');
          toast({
              type: 'success',
              title: 'Schedule updated successfully'
          });
          this.closeForm();
          this.$Progress.finish();
        })
        .catch(()=> { this.$Progress.fail(); });
      },

      // update() {
      //   axios.patch('/schedules/' + this.schedule.id, {
      //     start_at  : this.schedule.start_at,
      //     end_at    : this.schedule.end_at
      //   });
        
      //   this.editing = false;
      // },

      destroy() {
        if (confirm("You really want to delete this schedule?")) {

          axios.delete('/schedules/' + this.schedule.id)
          .then(() => {
            toast({
                type: 'success',
                title: 'Schedule deleted successfully'
            });
            this.$Progress.finish();
            this.$forceUpdate();
          });
              
          $(this.$el).fadeOut(500);
        }
      },

      closeForm() {
        this.form.clear(); // VForm: Clear error messages
        this.form.reset(); // VForm: Reset form fields
        this.creating = false;
        this.editing  = false;
      },
    },
  }
</script>
