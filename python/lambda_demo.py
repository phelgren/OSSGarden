def increment_it (n): return lambda x: x + n

f = increment_it(2)
g = increment_it(6)

print f(42), g(42)

print increment_it(22) (33)