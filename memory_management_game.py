import random

class MemoryManager:
    def _init_(self, total_memory):
        self.total_memory = total_memory
        self.free_memory = total_memory
        self.memory_map = []

    def allocate_first_fit(self, size):
        for i, block in enumerate(self.memory_map):
            if block[1] >= size:
                allocated_block = (block[0], size)
                self.memory_map[i] = (block[0] + size, block[1] - size)
                self.free_memory -= size
                return allocated_block
        return None

    def allocate_best_fit(self, size):
        best_fit_index = -1
        best_fit_size = float('inf')
        for i, block in enumerate(self.memory_map):
            if block[1] >= size and block[1] - size < best_fit_size:
                best_fit_index = i
                best_fit_size = block[1] - size
        if best_fit_index != -1:
            allocated_block = (self.memory_map[best_fit_index][0], size)
            self.memory_map[best_fit_index] = (self.memory_map[best_fit_index][0] + size, 
                                                self.memory_map[best_fit_index][1] - size)
            self.free_memory -= size
            return allocated_block
        return None

    def allocate_worst_fit(self, size):
        worst_fit_index = -1
        worst_fit_size = -1
        for i, block in enumerate(self.memory_map):
            if block[1] >= size and block[1] > worst_fit_size:
                worst_fit_index = i
                worst_fit_size = block[1]
        if worst_fit_index != -1:
            allocated_block = (self.memory_map[worst_fit_index][0], size)
            self.memory_map[worst_fit_index] = (self.memory_map[worst_fit_index][0] + size, 
                                                 self.memory_map[worst_fit_index][1] - size)
            self.free_memory -= size
            return allocated_block
        return None

    def deallocate(self, block):
        self.memory_map.append(block)
        self.memory_map.sort()
        self._merge_adjacent_blocks()
        self.free_memory += block[1]

    def _merge_adjacent_blocks(self):
        i = 0
        while i < len(self.memory_map) - 1:
            if self.memory_map[i][0] + self.memory_map[i][1] == self.memory_map[i+1][0]:
                self.memory_map[i] = (self.memory_map[i][0], self.memory_map[i][1] + self.memory_map[i+1][1])
                del self.memory_map[i+1]
            else:
                i += 1

def play_memory_management_game(strategy):
    total_memory = 1000  # Total memory size
    manager = MemoryManager(total_memory)
    allocation_requests = [(random.randint(50, 200), random.randint(1, 10)) for _ in range(10)]

    print(f"Memory Management Game (Strategy: {strategy})")
    print("Initial Free Memory:", manager.free_memory)

    for i, request in enumerate(allocation_requests, start=1):
        print(f"\nRequest {i}: Allocate {request[1]} units of memory")
        if strategy == "first_fit":
            allocated_block = manager.allocate_first_fit(request[1])
        elif strategy == "best_fit":
            allocated_block = manager.allocate_best_fit(request[1])
        elif strategy == "worst_fit":
            allocated_block = manager.allocate_worst_fit(request[1])
        if allocated_block:
            print(f"Allocated Block: {allocated_block}")
        else:
            print("Allocation failed. Not enough free memory.")

    print("\nFinal Free Memory:", manager.free_memory)

def display_algorithm_info():
    print("Memory Allocation Algorithms:")
    print("-----------------------------")
    print("1. First Fit: Allocate the first available block that is large enough.")
    print("   - Pros: Simple and fast. Requires minimal searching.")
    print("   - Cons: May lead to fragmentation. May not find the best fit.")
    print("2. Best Fit: Allocate the smallest available block that is large enough.")
    print("   - Pros: Minimizes fragmentation. Tends to use memory efficiently.")
    print("   - Cons: Requires searching for the best fit, which can be slow.")
    print("3. Worst Fit: Allocate the largest available block.")
    print("   - Pros: Reduces fragmentation. Tends to use memory efficiently.")
    print("   - Cons: Similar to Best Fit, but may lead to more fragmentation.")
    print()

def main():
    display_algorithm_info()
    strategy = input("Choose a memory allocation strategy (1: First Fit, 2: Best Fit, 3: Worst Fit): ")
    if strategy == "1":
        play_memory_management_game("first_fit")
    elif strategy == "2":
        play_memory_management_game("best_fit")
    elif strategy == "3":
        play_memory_management_game("worst_fit")
    else:
        print("Invalid choice. Please choose 1, 2, or 3.")

if __name__ == "_main_":
    main()