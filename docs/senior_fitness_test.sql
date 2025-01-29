SELECT
    test_name, test_code,
    sex, min_age, max_age, 
    min_ref, max_ref,
CASE
	WHEN min_ref < max_ref AND 10 < min_ref THEN 'below normal'
	WHEN min_ref < max_ref AND 10 > max_ref THEN 'above normal'
	WHEN min_ref > max_ref AND 10 > min_ref THEN 'below normal'
	WHEN min_ref > max_ref AND 10 < max_ref THEN 'above normal'
	ELSE 'normal'
END as assessment
FROM public.fullerton_test WHERE
	test_code = 'arm_curl' AND 
	65 <= min_age and 65 <= max_age AND
    sex = 'M'