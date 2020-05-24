<div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
	<div class="container mx-auto px-4 py-2 md:py-10">
		<div class="mb-5 w-64">

			<label for="datepicker" class="font-bold mb-1 text-gray-700 block">Select Date</label>
			<div class="relative">
				<input type="hidden" name="date" x-ref="date" value="1978-05-04">
				<input
					type="text"
					readonly
					x-model="datepickerValue"
					@click="showDatepicker = !showDatepicker"
					@keydown.escape="showDatepicker = false"
					class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
					placeholder="Select date">

          <!-- Calendar icon -->
					<div class="absolute top-0 right-0 px-3 py-2" @click="showDatepicker = !showDatepicker">
						<svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
						</svg>
					</div>



					<div
						class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0"
						style="width: 17rem"
						x-show.transition="showDatepicker"
						@click.away="showDatepicker = false">

            <!-- Years View -->
            <div x-show.transition="getView()=='years'">
              <!-- Years Header -->
              <div class="flex justify-between items-center mb-2">
                  <!-- Decade -->
                  <span x-text="getDecadeRange()" class="ml-1 text-lg text-gray-600 font-normal"></span>
                <div>
                  <!-- prev decade-->
                  <button
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                    @click="decade=decade-10; getNoOfDays()">
                    <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                  </button>
                  <!-- next decade -->
                  <button
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                    @click="decade=decade+10; getNoOfDays()">
                    <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Years List -->
              <div class="flex flex-wrap -mx-1">
                <template x-for="(yearVal, yearIndex) in DECADE_YEARS" :key="yearIndex">
                  <div style="width: 25%" class="px-1 mb-1">
                    <div
                      @click="setYear(yearVal+decade); showMonths()"
                      x-text="yearVal+decade"
                      class="cursor-pointer text-center text-sm leading-none rounded leading-loose transition ease-in-out duration-100"
                      :class="{'bg-blue-500 text-white': isThisYear(yearVal+decade) == true, 'text-gray-700 hover:bg-blue-200': isThisYear(yearVal+decade) == false }"
                    ></div>
                  </div>
                </template>
              </div>

            </div>


            <!-- Months View -->
            <div x-show.transition="getView()=='months'">
              <!-- Months Header -->
              <div class="flex justify-between items-center mb-2">
                <div
                     class="px-2 text-gray-700 hover:bg-blue-200 cursor-pointer text-center text-sm leading-none rounded leading-loose transition ease-in-out duration-100"
                     @click="showYears">
                  <!-- Year -->
                  <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                </div>
                <div>
                  <!-- prev year-->
                  <button
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                    @click="setPrevYear(); getNoOfDays()">
                    <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                  </button>
                  <!-- next year -->
                  <button
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                    @click="setNextYear(); getNoOfDays()">
                    <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Months List -->
              <div class="flex flex-wrap -mx-1">
                <template x-for="(monthName, monthIndex) in MONTH_ABBR" :key="monthIndex">
                  <div style="width: 25%" class="px-1 mb-1">
                    <div
                      @click="setMonth(monthIndex); showDays(); getNoOfDays()"
                      x-text="monthName"
                      class="cursor-pointer text-center text-sm leading-none rounded leading-loose transition ease-in-out duration-100"
                      :class="{'bg-blue-500 text-white': isThisMonth(year, monthIndex) == true, 'text-gray-700 hover:bg-blue-200': isThisMonth(year, monthIndex) == false }"
                    ></div>
                  </div>
                </template>
              </div>

            </div>


            <!-- Days View -->
            <div x-show.transition="getView()=='days'">

						<div class="flex justify-between items-center mb-2">
							<div
                   class="px-2 text-gray-700 hover:bg-blue-200 cursor-pointer text-center text-sm leading-none rounded leading-loose transition ease-in-out duration-100"
                   @click="showMonths">
                <!-- Month and Year -->
								<span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
								<span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
							</div>
							<div>
                <!-- prev month -->
								<button
									type="button"
									class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
									@click="setPrevMonth(); getNoOfDays()">
									<svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
									</svg>
								</button>
                <!-- next month -->
								<button
									type="button"
									class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
									@click="setNextMonth(); getNoOfDays()">
									<svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
									</svg>
								</button>
							</div>
						</div>

						<div class="flex flex-wrap mb-3 -mx-1">
							<template x-for="(day, index) in DAYS" :key="index">
								<div style="width: 14.26%" class="px-1">
									<div
										x-text="day"
										class="text-gray-800 font-medium text-center text-xs"></div>
								</div>
							</template>
						</div>

						<div class="flex flex-wrap -mx-1">
              <!-- days -->
							<template x-for="blankday in blankdays">
								<div
									style="width: 14.28%"
									class="text-center border p-1 border-transparent text-sm"
								></div>
							</template>
							<template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
								<div style="width: 14.28%" class="px-1 mb-1">
									<div
										@click="getDateValue(date)"
										x-text="date"
										class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
										:class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"
									></div>
								</div>
							</template>
						</div>

            </div>

					</div>

			</div>
		</div>

	</div>
</div>

<script>
	const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  const MONTH_ABBR = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

  const DECADE_YEARS = [0,1,2,3,4,5,6,7,8,9];

	function app() {
		return {
			showDatepicker: false,
			datepickerValue: '',

			month: '',
			year: '',
      decade: '',
			no_of_days: [],
			blankdays: [],
			days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

      formatDateString(d) {
        return `${DAYS[d.getUTCDay()]}, ${MONTH_ABBR[d.getUTCMonth()]} ${d.getUTCDate()}, ${d.getUTCFullYear()}`;
      },

			initDate() {

				let selectedDate = new Date(this.$refs.date.value+'T00:00:00.000+00:00');

        this.month = selectedDate.getUTCMonth();
				this.year = selectedDate.getUTCFullYear();

        this.decade = Math.floor(this.year / 10) * 10;
				this.datepickerValue = this.formatDateString(selectedDate);
			},

			isToday(date) {
				const today = new Date();
				const d = new Date(this.year, this.month, date);

				return today.toDateString() === d.toDateString() ? true : false;
			},

			getDateValue(date) {
				let selectedDate = new Date(this.year, this.month, date);
				this.datepickerValue = this.formatDateString(selectedDate);

				this.$refs.date.value = selectedDate.getUTCFullYear() +"-"+ ('0'+ (selectedDate.getUTCMonth()+1)).slice(-2) +"-"+ ('0' + selectedDate.getUTCDate()).slice(-2);

				console.log(this.$refs.date.value);

				this.showDatepicker = false;
			},

			getNoOfDays() {
				let daysInMonth = new Date(this.year, this.month + 1, 0).getUTCDate();

				// find where to start calendar day of week
				let dayOfWeek = new Date(this.year, this.month).getUTCDay();
				let blankdaysArray = [];
				for ( var i=1; i <= dayOfWeek; i++) {
					blankdaysArray.push(i);
				}

				let daysArray = [];
				for ( var i=1; i <= daysInMonth; i++) {
					daysArray.push(i);
				}

				this.blankdays = blankdaysArray;
				this.no_of_days = daysArray;
			},

			views: ['days', 'months', 'years', 'decades'],
      view: 'days',

      getToday() {
        return new Date();
      },

      showDays() {
        this.setView('days');
      },

      showMonths() {
        this.setView('months');
      },

      showYears() {
        this.setView('years');
      },

      viewYears() {
        this.setView('decades');
      },

      setView(view) {
        this.view = view;
        console.log(this.view);
      },

      getView() {
        return this.view;
      },

      isThisMonth(year, month) {
				const today = new Date();
        const t = new Date(today.getUTCFullYear(), today.getUTCMonth(), 1);
				const d = new Date(year, month, 1);
				return t.toDateString() === d.toDateString() ? true : false;
      },

      setMonth(month) {
        this.month = month;
      },

      setNextMonth() {
        if (this.month == 11) {
          this.month=0;
          this.setNextYear();
        } else {
          this.month++;
        }
      },

      setPrevMonth() {
        if (this.month == 0) {
          this.month=11;
          this.setPrevYear();
        } else {
          this.month--;
        }
      },

      setPrevYear() {
        if (this.year % 10 == 0) {
          this.decade=this.decade-10;
        }
        this.year--;
      },

      setNextYear() {
        if (this.year % 10 == 9) {
          this.decade=this.decade+10;
        }
        this.year++;
      },

      getDecadeRange() {
        let endYear = this.decade + 9;
        return `${this.decade}-${endYear}`;
      },

      setYear(year) {
        this.year = year;
      },

      isThisYear(year) {
				const today = new Date();
        return year == today.getUTCFullYear();
      },

		}
	}
</script>

<link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
<style>
		[x-cloak] {
			display: none;
		}
	</style>
