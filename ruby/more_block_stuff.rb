

  def my_map(array)


    for element in array
      yield element
    end

  end

  my_map([1, 2, 3]) do |number|
    puts number * 2
  end

