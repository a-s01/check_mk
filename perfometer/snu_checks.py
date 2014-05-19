def perfometer_check_mk_cisco_chassis_load(row, check_command, perf_data):
    return perfometer_bandwidth(
            savefloat(perf_data[0][1]), 
            savefloat(perf_data[1][1]),
            100, 
            100, 
            ''
        )

perfometers["check_mk-cisco_chassis_load"] = perfometer_check_mk_cisco_chassis_load
perfometers["check_mk-if64_snu"] = perfometer_check_mk_if
