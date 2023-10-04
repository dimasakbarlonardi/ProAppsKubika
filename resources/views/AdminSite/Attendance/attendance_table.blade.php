<table>
    <thead>
        <tr>
            <th></th>
            @php
                $getDate = strtotime($nowDate);
                $date = date('F Y', $getDate);
                $dates = [];
                while (strtotime($date) <= strtotime(date('Y-m', $getDate) . '-' . date('t', strtotime($date)))) {
                    $month = date('F', strtotime($date)); //Day number
                    $day_num = date('j', strtotime($date)); //Day number
                    $day_name = date('D', strtotime($date)); //th, nd, st and rd
                    $day = "$month $day_name $day_num";
                    $dates[] = date('Y', strtotime($date)) . '-' . date('m', strtotime($date)) . '-' . date('d', strtotime($date));
                    $date = date('Y-m-d', strtotime('+1 day', strtotime($date))); //Adds 1 day onto current date
                    $weekend = $day_name == 'Sun' || $day_name == 'Sat' ? "style='background: red; color: white;'" : '';
                    echo '<th ' . $weekend . '>' . $day . '</th>';
                }
            @endphp
        </tr>
    </thead>
    <tbody>
        @foreach ($karyawans as $karyawan)
            <tr>
                <td>{{ $karyawan->nama_karyawan }}</td>
                @foreach ($dates as $date)
                    <td class="text-center" style="width: 100%">
                        {{-- @foreach ($karyawan->WorkSchedule as $key1 => $schedule)
                            <div
                                style="width: {{ count($karyawan->User->Attendance) > 0 ? '300px' : '' }}; padding: 20px 20px; display:{{ $schedule->date == $date ? 'block' : 'none' }}">
                                @foreach ($karyawan->User->Attendance as $attendance)
                                    @if ($attendance->status_absence != 'Alpha')
                                        <span><b>{{ $attendance->status_absence }}</b></span> <br>
                                        <span><b>Clock In :
                                            </b>{{ HumanTime($attendance->check_in) }}</span> <br>
                                        <span><b>Clock Out :
                                            </b>{{ HumanTime($attendance->check_out) }}</span> <br>
                                        <span><b>Work Hour : </b>{{ $attendance->work_hour }}</span>
                                    @elseif ($attendance->status_absence == 'Alpha')
                                        <span><b>Alpha</b></span>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach --}}
                        @foreach ($karyawan->WorkSchedule as $schedule)
                            <div
                                style="display:{{ $schedule->date == $date && $schedule->status_absence ? 'block' : 'none' }}">
                                {{ $schedule->status_absence }} <br> <br> {{ $date }}
                            </div>
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
