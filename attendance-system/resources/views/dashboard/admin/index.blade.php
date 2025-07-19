@extends('layouts.main')

@section('title',ucwords(__('main.control_panel')))

@section('content')

  <!-- Main Content -->
  <div class="content p-4">
      <!-- نظرة عامة -->
      <section id="overview" class="section active">
          <h2 class="mb-4">{{ucwords(__('main.overview'))}}</h2>
          <div class="row">
              <div class="col-md-3 mb-4">
                  <a href="{{route('teachers.index')}}" style="text-decoration: none;">
                      <div class="card text-white" style="background: linear-gradient(45deg, #FFA500, #228B22);">
                          <div class="card-body">
                              <h5 class="card-title text-white" style="color: #228b22cb;">{{ucwords(__('main.number_of_doctors'))}}</h5>
                              <p class="card-text text-white" style="color: #228b22cb;"><strong>{{$teachersCount}}</strong></p>
                          </div>
                      </div>
                  </a>
              </div>
              <div class="col-md-3 mb-4">
                  <a href="{{route('courses.index')}}" style="text-decoration: none;">
                      <div class="card text-white" style="background: linear-gradient(45deg, #FFA500, #228B22);">
                          <div class="card-body">
                              <h5 class="card-title text-white" style="color: #228b22cb;">{{ucwords(__('main.number_of_courses'))}}</h5>
                              <p class="card-text text-white" style="color: #228b22cb;"><strong>{{$coursesCount}}</strong></p>
                          </div>
                      </div>
                  </a>
              </div>
              <div class="col-md-3 mb-4">
                  <a href="{{route('students.index')}}" style="text-decoration: none;">
                      <div class="card text-white" style="background: linear-gradient(45deg, #FFA500, #228B22);">
                          <div class="card-body">
                              <h5 class="card-title text-white" style="color: #228b22cb;">{{ucwords(__('main.number_of_students'))}}</h5>
                              <p class="card-text text-white" style="color: #228b22cb;"><strong>{{$studentsCount}}</strong></p>
                          </div>
                      </div>
                  </a>
              </div>

              <div class="col-md-3 mb-4">
                  <a href="{{route('employees.index')}}" style="text-decoration: none;">
                      <div class="card text-white" style="background: linear-gradient(45deg, #FFA500, #228B22);">
                          <div class="card-body">
                              <h5 class="card-title text-white" style="color: #228b22cb;">{{ucwords(__('main.number_of_employees'))}}</h5>
                              <p class="card-text text-white" style="color: #228b22cb;"><strong>{{$employeesCount}}</strong></p>
                          </div>
                      </div>
                  </a>
              </div>
          </div>
      </section>

@endsection
