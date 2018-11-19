<script>
  export default {
    props: [ 'the_doctor','the_schedule','edit','the_day' ],

    data() {
      return {
        creating: false,
        editing : this.edit,
        day     : this.the_day,
        doctor  : this.the_doctor,
        schedule: this.the_schedule,
      };
    },

    computed: {
      //
    },

    methods: {
      create() {
        axios.post('/schedules', {
          doctor_id : this.doctor.id,
          start_at  : this.start_at,
          end_at    : this.end_at
        });
        
        this.creating = false;
      },

      update() {
        axios.patch('/schedules/' + this.schedule.id, {
          start_at  : this.schedule.start_at,
          end_at    : this.schedule.end_at
        });
        
        this.editing = false;
      },

      destroy() {
        if (confirm("You really want to delete this schedule?")) {
          axios.delete('/schedules/' + this.schedule.id);
          $(this.$el).fadeOut(500, () => {              
            flash('Schedule was deleted.');
          });
        }
      }
    },
  }
</script>
